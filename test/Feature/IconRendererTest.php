<?php

declare(strict_types=1);

namespace Hedger\Unicon\Test\Feature;

use Hedger\Unicon\IconCache;
use Hedger\Unicon\IconDownloader;
use Hedger\Unicon\IconRenderer;
use Hedger\Unicon\Test\TestCase;
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
}
