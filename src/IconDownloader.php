<?php

declare(strict_types=1);

namespace Hedger\Unicon;

use Illuminate\Support\Facades\Http;

/**
 * Iconify icon downloader.
 */
class IconDownloader
{
    /**
     * Downloads an icon from the Iconify API.
     *
     * This method will attempt to resolve the icon by calling the Iconify API.
     *
     * @param  string  $prefix  The prefix of the icon to download.
     * @param  string  $name  The name of the icon to download.
     *
     * @returns string  The icon as an SVG string.
     * @returns null    If the icon could not be resolved.
     */
    public function download(string $prefix, string $name): ?string
    {
        try {
            return Http::baseUrl(config('unicon.iconify.url'))
                ->timeout(config('unicon.iconify.timeout', 5))
                ->get("$prefix/$name.svg")
                ->throwUnlessStatus(200)
                ->body();
        } catch (\Exception) {
            return null;
        }
    }
}
