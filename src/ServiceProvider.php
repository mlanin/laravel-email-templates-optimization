<?php

namespace Lanin\Laravel\EmailTemplatesEngine;

use Illuminate\View\Engines\CompilerEngine;

class ServiceProvider extends \Illuminate\Support\ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $configPath = __DIR__ . '/config/view.php';

        $this->mergeConfigFrom($configPath, 'view');
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->registerEmailEngine();
    }

    /**
     * Register the Blade engine implementation.
     *
     * @return void
     */
    public function registerEmailEngine()
    {
        $app = $this->app;

        $app->bind('email.compiler', function () use ($app) {
            $cache = $app['config']['view.compiled'];
            $css = $app['config']['view.emails.css-files'];

            return new Compiler($app['files'], $cache, $css);
        });

        $app['view']->addExtension('email.php', 'email', function () use ($app) {
            return new CompilerEngine($app['email.compiler']);
        });
    }
}