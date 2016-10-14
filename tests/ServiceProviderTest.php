<?php namespace Lanin\Laravel\EmailTemplatesEngine\Tests;

use Lanin\Laravel\EmailTemplatesEngine\Compiler;
use Lanin\Laravel\EmailTemplatesEngine\ServiceProvider;

class ServiceProviderTest extends TestCase
{
    /** @var ServiceProvider */
    private $provider;

    public function setUp()
    {
        parent::setUp();
        $this->provider = $this->app->getProvider(ServiceProvider::class);
    }

    public function tearDown()
    {
        parent::tearDown();
        unset($this->provider);
    }

    /** @test */
    public function it_can_get_provide_compiler()
    {
        $provided = $this->provider->provides();
        $defaults = ['email.compiler'];
        $this->assertCount(count($defaults), $provided);
        $this->assertEquals($defaults, $provided);

        $this->assertInstanceOf(Compiler::class, $this->app['email.compiler']);
    }

    /** @test */
    public function it_cat_publish_config()
    {
        $config = $this->app['config'];
        $this->assertArrayHasKey('view', $config);
        $this->assertArrayHasKey('view.emails.css_files', $config);
    }
}