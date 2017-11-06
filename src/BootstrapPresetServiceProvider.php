<?php

namespace LaravelNews\Presets\BootstrapFour;

use Illuminate\Support\ServiceProvider;
use Illuminate\Foundation\Console\PresetCommand;

class BootstrapPresetServiceProvider extends ServiceProvider
{
    public function boot()
    {
        PresetCommand::macro('bootstrap4', function ($command) {
            BootstrapPreset::install();

            $command->info('Bootstrap (v4) scaffolding installed successfully.');
            $command->info('Please run "npm install && npm run dev" to compile your fresh scaffolding.');
        });

        PresetCommand::macro('bootstrap4-auth', function ($command) {
            BootstrapPreset::installAuth();

            $command->info('Bootstrap (v4) scaffolding with auth views installed successfully.');
            $command->info('Please run "npm install && npm run dev" to compile your fresh scaffolding.');
        });
    }
}