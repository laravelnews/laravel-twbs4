<?php

namespace LaravelNews\Presets\BootstrapFour;

use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Arr;
use Illuminate\Foundation\Console\Presets\Preset;

class BootstrapPreset extends Preset
{
    public static function install()
    {
        static::updatePackages();
        static::updateSass();
        static::updateBootstrapping();
        static::updateWelcomePage();
        static::removeNodeModules();
    }

    public static function installAuth()
    {
        // noop
    }

    protected static function updatePackageArray(array $packages)
    {
        return [
            'bootstrap' => '^4.0.0-beta.2',
            'popper.js' => '^1.12.6'
        ] + Arr::except($packages, ['bootstrap-sass']);
    }

    protected static function updateWelcomePage()
    {
        (new Filesystem)->delete(resource_path('views/welcome.blade.php'));

        copy(__DIR__ . '/bootstrap-stubs/views/welcome.blade.php', resource_path('views/welcome.blade.php'));
    }

    protected static function updateBootstrapping()
    {
        copy(__DIR__ . '/bootstrap-stubs/webpack.mix.js', base_path('webpack.mix.js'));
        copy(__DIR__ . '/bootstrap-stubs/bootstrap.js', resource_path('assets/js/bootstrap.js'));
    }

    /**
     * Update the Sass files for the application.
     *
     * @return void
     */
    protected static function updateSass()
    {
        copy(__DIR__ . '/bootstrap-stubs/sass/_variables.scss', resource_path('assets/sass/_variables.scss'));
        copy(__DIR__ . '/bootstrap-stubs/sass/app.scss', resource_path('assets/sass/app.scss'));
    }
}