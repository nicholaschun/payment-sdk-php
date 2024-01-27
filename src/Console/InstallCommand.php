<?php

namespace Nicholaschun\PaymentSDK\Console;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class InstallCommand extends Command
{
    protected $signature = 'payment-sdk:install';

    protected $description = 'Install Payment SDK';

    public function handle(): void
    {
        $this->info('Installing Payment SDK...');

        $this->handleConfigPublishing();

        $this->info('Installed Payment SDK');
    }

    private function handleConfigPublishing(): void
    {
        $this->info('Publishing configuration...');

        if (!$this->configExists()) {
            $this->publishConfiguration();
            $this->info('Published configuration');
        } else {
            if ($this->shouldOverwriteConfig()) {
                $this->info('Overwriting configuration file...');
                $this->publishConfiguration($force = true);
            } else {
                $this->info('Existing configuration was not overwritten');
            }
        }
    }

    private function configExists(): bool
    {
        return File::exists(config_path('pay-config.php'));
    }

    private function shouldOverwriteConfig(): bool
    {
        return $this->confirm(
            'Config file already exists. Do you want to overwrite it?',
            false
        );
    }

    private function publishConfiguration($forcePublish = false): void
    {
        $params = [
            '--provider' => "Nicholaschun\PaymentSDK\PaymentSDKServiceProvider",
            '--tag' => "pay-config"
        ];

        if ($forcePublish === true) {
            $params['--force'] = true;
        }

        $this->call('vendor:publish', $params);
    }
}