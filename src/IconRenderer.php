<?php

declare(strict_types=1);

namespace Hedger\Unicon;

use Illuminate\Support\Str;

class IconRenderer
{
    public function __construct(
        protected IconCache $cache,
        protected IconDownloader $downloader,
    ) {}

    public function render(string $name): ?string
    {
        if (! Str::contains($name, ':')) {
            throw new \InvalidArgumentException(
                'The name must be in the format "prefix:name".',
            );
        }

        [$prefix, $name] = explode(':', $name, 2);

        $icon = match ($isInCache = $this->cache->has($prefix, $name)) {
            true => $this->cache->pull($prefix, $name),
            false => $this->downloader->download($prefix, $name),
        };

        // If the icon was not found in the cache, store it in the cache.
        if (! $isInCache && ! is_null($icon)) {
            $this->cache->put($prefix, $name, $icon);
        }

        return $icon;
    }
}
