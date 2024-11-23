<?php

declare(strict_types=1);

namespace Unicon\Test\Feature;

use Illuminate\Support\Facades\Config;
use Unicon\IconCache;
use Unicon\IconDownloader;
use Unicon\IconRenderer;
use Unicon\Test\TestCase;
use Mockery\Adapter\Phpunit\MockeryPHPUnitIntegration;
use PHPUnit\Framework\Attributes\Test;

class IconRendererTest extends TestCase
{
    use MockeryPHPUnitIntegration;

    #[Test]
    public function it_retrieves_the_icon_from_the_iconify_api_on_first_render()
    {
        $this->partialMock(IconDownloader::class)
            ->shouldReceive('download')
            ->with('heroicons', 'clock')
            ->once();

        $renderer = $this->app->make(IconRenderer::class);

        $renderer->render('heroicons:clock');
    }

    #[Test]
    public function it_retrieves_the_icon_from_the_cache_on_subsequent_renders()
    {
        $this->partialMock(IconDownloader::class)
            ->shouldReceive('download')
            ->once()
            ->andReturn($this->icon);

        $this->partialMock(IconCache::class)
            ->shouldReceive('pull')
            ->once()
            ->andReturn($this->icon);

        $renderer = $this->app->make(IconRenderer::class);

        $renderer->render('heroicons:clock'); // downloads the icon
        $renderer->render('heroicons:clock'); // pulls the icon from the cache
    }

    #[Test]
    public function test_it_uses_the_defaullt_prefix_if_the_prefix_is_not_specified()
    {
        $this->partialMock(IconDownloader::class)
            ->shouldReceive('download')
            ->once()
            ->with('heroicons', 'clock')
            ->andReturn($this->icon);

        Config::set('unicon.defaults.prefix', 'heroicons');

        $renderer = $this->app->make(IconRenderer::class);
        $renderer->render('clock');
    }
}
