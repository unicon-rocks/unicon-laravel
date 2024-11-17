<?php

declare(strict_types=1);

namespace Hedger\Unicon\Test\Feature;

use Hedger\Unicon\IconDownloader;
use Hedger\Unicon\Test\TestCase;
use Illuminate\Http\Client\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Http;
use PHPUnit\Framework\Attributes\Test;

class IconDownloaderTest extends TestCase
{
    #[Test]
    public function it_downloads_the_icon_from_the_iconify_api()
    {
        Http::fake();

        app(IconDownloader::class)->download('heroicons', 'clock');

        Http::assertSent(function (Request $request) {
            return $request->url() === 'https://api.iconify.design/heroicons/clock.svg';
        });
    }

    #[Test]
    public function it_downloads_the_icon_from_a_custom_iconify_api_url()
    {
        Http::fake();
        Config::set('unicon.iconify.url', 'http://localhost:3000');

        app(IconDownloader::class)->download('heroicons', 'clock');

        Http::assertSent(function (Request $request) {
            return $request->url() === 'http://localhost:3000/heroicons/clock.svg';
        });
    }
}
