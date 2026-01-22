<?php

namespace App\Services;

use Codewithkyrian\Transformers\Models\Auto\AutoModel;
use Codewithkyrian\Transformers\Models\Pretrained\PretrainedModel;
use Codewithkyrian\Transformers\Processors\AutoProcessor;
use Codewithkyrian\Transformers\Processors\Processor;
use Codewithkyrian\Transformers\Utils\Image as TransformersImage;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class BackgroundRemovalService
{
    private string $modelName;

    private float $borderTolerance;

    private int $colorThreshold;

    private ?PretrainedModel $model = null;

    private ?Processor $processor = null;

    public function __construct()
    {
        $config = config('services.background_removal', []);

        $this->modelName = $config['model'] ?? 'briaai/RMBG-1.4';
        $this->borderTolerance = (float) ($config['border_tolerance'] ?? 0.05);
        $this->colorThreshold = (int) ($config['color_threshold'] ?? 30);
    }

    public function handle(string $absolutePath): bool
    {
        // Allow up to 5 minutes for background removal processing
        set_time_limit(300);
        
        // Check if FFI is properly configured
        if (!extension_loaded('ffi')) {
            Log::error('FFI extension is not loaded. Background removal cannot work.', [
                'path' => $absolutePath,
                'help' => 'Enable FFI in php.ini and restart your web server. See FIX_FFI_NOW.md for instructions.'
            ]);
            return false;
        }

        $ffiEnabled = ini_get('ffi.enable');
        if ($ffiEnabled !== '1' && $ffiEnabled !== 'true') {
            Log::error('FFI is not enabled. Current value: ' . $ffiEnabled, [
                'path' => $absolutePath,
                'current_setting' => $ffiEnabled,
                'required_setting' => 'true',
                'help' => 'Set ffi.enable=true in php.ini. See FIX_FFI_NOW.md for instructions.'
            ]);
            return false;
        }

        if (!is_file($absolutePath)) {
            Log::warning('Image file does not exist.', ['path' => $absolutePath]);
            return false;
        }

        Log::info('Starting background removal process.', [
            'path' => $absolutePath,
            'file_size' => filesize($absolutePath)
        ]);

        if (!$this->containsBackground($absolutePath)) {
            Log::info('Image does not contain background (edges are white). Skipping processing.', [
                'path' => $absolutePath
            ]);
            return false;
        }

        $transparentPath = $this->generateTransparent($absolutePath);

        if (!$transparentPath) {
            Log::error('Failed to generate transparent image.', ['path' => $absolutePath]);
            return false;
        }

        try {
            $this->flattenOnWhite($transparentPath, $absolutePath);
            Log::info('Background removal completed successfully.', ['path' => $absolutePath]);
        } catch (\Throwable $exception) {
            Log::warning('Unable to compose background removal result.', [
                'path' => $absolutePath,
                'message' => $exception->getMessage(),
                'trace' => $exception->getTraceAsString()
            ]);

            return false;
        } finally {
            if (is_file($transparentPath)) {
                @unlink($transparentPath);
            }
        }

        return true;
    }

    private function generateTransparent(string $absolutePath): ?string
    {
        try {
            Log::debug('Reading image for background removal.', ['path' => $absolutePath]);
            $image = TransformersImage::read($absolutePath);

            Log::debug('Processing image with AI model.', [
                'width' => $image->width(),
                'height' => $image->height(),
                'model' => $this->modelName
            ]);

            ['pixel_values' => $pixelValues] = $this->getProcessor()($image);

            Log::debug('Running AI model inference...');
            ['output' => $output] = $this->getModel()(['input' => $pixelValues]);

            Log::debug('Creating mask from model output...');
            $mask = TransformersImage::fromTensor($output[0]->multiply(255))
                ->resize($image->width(), $image->height());

            Log::debug('Applying mask to image...');
            $maskedImage = $image->applyMask($mask);

            $temporaryPath = $this->temporaryPath();
            Log::debug('Saving transparent image.', ['temp_path' => $temporaryPath]);
            $maskedImage->save($temporaryPath);

            return $temporaryPath;
        } catch (\Throwable $exception) {
            Log::error('TransformersPHP background removal failed.', [
                'path' => $absolutePath,
                'message' => $exception->getMessage(),
                'file' => $exception->getFile(),
                'line' => $exception->getLine(),
                'trace' => $exception->getTraceAsString()
            ]);

            return null;
        }
    }

    private function getModel(): PretrainedModel
    {
        return $this->model ??= AutoModel::fromPretrained(modelNameOrPath: $this->modelName);
    }

    private function getProcessor(): Processor
    {
        return $this->processor ??= AutoProcessor::fromPretrained(modelNameOrPath: $this->modelName);
    }

    private function temporaryPath(): string
    {
        $directory = storage_path('app/background-removal');

        if (!is_dir($directory)) {
            mkdir($directory, 0755, true);
        }

        return $directory . DIRECTORY_SEPARATOR . Str::uuid() . '.png';
    }

    private function containsBackground(string $absolutePath): bool
    {
        $contents = @file_get_contents($absolutePath);

        if ($contents === false) {
            return false;
        }

        $image = @imagecreatefromstring($contents);

        if (!$image) {
            return false;
        }

        $width = imagesx($image);
        $height = imagesy($image);

        if ($width === 0 || $height === 0) {
            imagedestroy($image);

            return false;
        }

        $stepX = max(1, (int) floor($width / 40));
        $stepY = max(1, (int) floor($height / 40));
        $samples = 0;
        $nonWhite = 0;

        for ($x = 0; $x < $width; $x += $stepX) {
            foreach ([0, max(0, $height - 1)] as $y) {
                $samples++;

                if (!$this->isNearWhite($image, $x, $y)) {
                    $nonWhite++;
                }
            }
        }

        for ($y = 0; $y < $height; $y += $stepY) {
            foreach ([0, max(0, $width - 1)] as $x) {
                $samples++;

                if (!$this->isNearWhite($image, $x, $y)) {
                    $nonWhite++;
                }
            }
        }

        imagedestroy($image);

        if ($samples === 0) {
            return false;
        }

        $ratio = $nonWhite / $samples;

        return $ratio > $this->borderTolerance;
    }

    private function isNearWhite($image, int $x, int $y): bool
    {
        $index = imagecolorat($image, $x, $y);
        $red = ($index >> 16) & 0xFF;
        $green = ($index >> 8) & 0xFF;
        $blue = $index & 0xFF;

        $threshold = $this->colorThreshold;

        return abs(255 - $red) <= $threshold
            && abs(255 - $green) <= $threshold
            && abs(255 - $blue) <= $threshold;
    }

    private function flattenOnWhite(string $transparentPath, string $destinationPath): void
    {
        $contents = @file_get_contents($transparentPath);

        if ($contents === false) {
            throw new \RuntimeException('Unable to read generated transparent image.');
        }

        $foreground = @imagecreatefromstring($contents);

        if (!$foreground) {
            throw new \RuntimeException('Unable to create image from generated file.');
        }

        $width = imagesx($foreground);
        $height = imagesy($foreground);
        $background = imagecreatetruecolor($width, $height);
        $white = imagecolorallocate($background, 255, 255, 255);

        imagefill($background, 0, 0, $white);
        imagealphablending($background, true);
        imagesavealpha($background, false);
        imagecopy($background, $foreground, 0, 0, 0, 0, $width, $height);

        $extension = strtolower(pathinfo($destinationPath, PATHINFO_EXTENSION));

        if (in_array($extension, ['jpg', 'jpeg'], true)) {
            imagejpeg($background, $destinationPath, 92);
        } else {
            imagepng($background, $destinationPath, 9);
        }

        imagedestroy($background);
        imagedestroy($foreground);
    }
}
