<?php namespace Lanin\Laravel\EmailTemplatesEngine\Tests;

use Illuminate\Contracts\Console\Kernel;
use Symfony\Component\DomCrawler\Crawler;

class CompileTest extends TestCase
{
    public function setUp()
    {
        parent::setUp();
        $this->app['view']->addLocation(realpath(__DIR__ . '/fixture/resources/views'));
    }

    public function tearDown()
    {
        $this->app[Kernel::class]->call('view:clear');
        parent::tearDown();
    }

    /** @test */
    public function it_can_compile_email_templates()
    {
        $html = view('hello')->with('url', 'https://laravel.com')->with('name', 'Laravel')->__toString();
        $crawler = new Crawler($html);

        $this->assertEquals(1, $crawler->filter('.content a')->count());
        $this->assertEquals('https://laravel.com', $crawler->filter('.content a')->attr('href'));
        $this->assertEquals('line-height: 1; color: #000000; text-decoration: underline;', $crawler->filter('.content a')->attr('style'));
    }
}