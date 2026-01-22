<?php

namespace App\Console\Commands;

use App\Services\FeaturedProductRotationService;
use Illuminate\Console\Command;

class RotateFeaturedProducts extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'featured:rotate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check and rotate featured products if needed based on rotation settings';

    protected $rotationService;

    public function __construct(FeaturedProductRotationService $rotationService)
    {
        parent::__construct();
        $this->rotationService = $rotationService;
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Checking if featured products rotation is needed...');

        $rotated = $this->rotationService->checkAndRotateIfNeeded();

        if ($rotated) {
            $this->info('✓ Featured products rotated successfully!');
        } else {
            $this->info('- No rotation needed at this time.');
        }

        return 0;
    }
}
