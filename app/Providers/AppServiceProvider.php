<?php

namespace App\Providers;

use App\Models\Category;
use Codewithkyrian\Transformers\Transformers;
use Codewithkyrian\Transformers\Utils\ImageDriver;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $this->configureTransformers();

        // Share categories with navbar and topbar partials only
        View::composer(['partials.navbar', 'partials.topbar'], function ($view) {
            $categories = Category::withCount('products')->get();
            $view->with('categories', $categories);
        });
    }

    private function configureTransformers(): void
    {
        $cacheDir = storage_path('app/transformers');

        if (!is_dir($cacheDir)) {
            mkdir($cacheDir, 0755, true);
        }

        $logger = Log::channel(config('logging.default'));

        $setup = Transformers::setup()
            ->setCacheDir($cacheDir)
            ->setImageDriver(ImageDriver::GD)
            ->setLogger($logger);

        if ($token = config('services.background_removal.token')) {
            $setup->setAuthToken($token);
        }

        $setup->apply();
    }
}
