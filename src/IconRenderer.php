<?php

declare(strict_types=1);

namespace Unicon;

class IconRenderer
{
    public function __construct(
        protected IconCache $cache,
        protected IconDownloader $downloader,
    ) {}

    public function render(string $name): ?string
    {
        $parts = explode(':', $name, 2);

        $prefix = count($parts) === 2 ? $parts[0] : config('unicon.defaults.prefix');
        $name = count($parts) === 2 ? $parts[1] : $name;

        if (!$prefix) {
            throw new \InvalidArgumentException(
                'The prefix must be specified either in the name of the icon or in the configuration.',
            );
        }

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
