<?php

namespace LaravelNews\Presets\BootstrapFour;

use Illuminate\Container\Container;
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
        static::install();
        static::scaffoldAuth();
    }

    protected static function updatePackageArray(array $packages)
    {
        return [
            'bootstrap' => '^4.0.0',
            'popper.js' => '^1.12.9'
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

    protected static function scaffoldAuth()
    {
        file_put_contents(app_path('Http/Controllers/HomeController.php'), static::compileControllerStub());
        file_put_contents(
            base_path('routes/web.php'),
            "\nAuth::routes();\n\nRoute::get('/home', 'HomeController@index')->name('home');\n\n",
            FILE_APPEND
        );
        (new Filesystem)->copyDirectory(__DIR__.'/bootstrap-stubs/views', resource_path('views'));
    }

    protected static function compileControllerStub()
    {
        return str_replace(
            '{{namespace}}',
            Container::getInstance()->getNamespace(),
            file_get_contents(__DIR__.'/bootstrap-stubs/controllers/HomeController.stub')
        );
    }
}
