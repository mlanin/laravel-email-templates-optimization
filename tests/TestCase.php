<?php namespace Lanin\Laravel\EmailTemplatesOptimization\Tests;

use Lanin\Laravel\EmailTemplatesOptimization\ServiceProvider;
use Orchestra\Testbench\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    /**
     * Setup the test environment.
     */
    public function setUp()
    {
        parent::setUp();
    }


    /**
     * Define environment setup.
     *
     * @param  \Illuminate\Foundation\Application $app
     * @return void
     */
    protected function getEnvironmentSetUp($app)
    {
        /** @var \Illuminate\Config\Repository $config */
        $config = $app['config'];

        $config->set('view.paths',[
            realpath(__DIR__ . '/fixture/resources/views'),
        ]);
        $config->set('view.compiled', realpath(__DIR__ . '/fixture/storage/framework/views'));

        $config->set('view.emails.css_files', [
            realpath(__DIR__ . '/fixture/resources/assets/app.css')
        ]);
    }

    /**
     * Get package providers.
     *
     * @param  \Illuminate\Foundation\Application $app
     *
     * @return array
     */
    protected function getPackageProviders($app)
    {
        return [
            ServiceProvider::class,
        ];
    }
}