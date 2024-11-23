<?php

declare(strict_types=1);

namespace Unicon;

use Illuminate\Contracts\Filesystem\Filesystem;
use Illuminate\Support\Facades\Storage;

class IconCache
{
    /**
     * Puts an icon in the cache.
     *
     * @param  string  $prefix  The prefix of the icon to put.
     * @param  string  $name  The name of the icon to put.
     * @param  string  $svg  The SVG string of the icon to put.
     * @return bool True if the icon was successfully put in the cache,
     *              false otherwise.
     */
    public function put(string $prefix, string $name, string $svg): bool
    {
        return $this->getDisk()->put($this->getPath($prefix, $name), $svg);
    }

    /**
     * Checks if an icon is in the cache.
     *
     * @param  string  $prefix  The prefix of the icon to check.
     * @param  string  $name  The name of the icon to check.
     * @return bool True if the icon is in the cache, false otherwise.
     */
    public function has(string $prefix, string $name): bool
    {
        return $this->getDisk()->exists($this->getPath($prefix, $name));
    }

    /**
     * Pulls an icon from the cache.
     *
     * @param  string  $prefix  The prefix of the icon to pull.
     * @param  string  $name  The name of the icon to pull.
     * @return string|null The SVG string of the icon, or null if the icon
     *                     was not found in the cache.
     */
    public function pull(string $prefix, string $name): ?string
    {
        if (!$this->has($prefix, $name)) {
            return null;
        }

        return $this->getDisk()->get($this->getPath($prefix, $name));
    }

    public function clear(): void
    {
        $this->getDisk()->deleteDirectory('icons');
    }

    protected function getDisk(): Filesystem
    {
        return Storage::disk(config('unicon.cache.disk.driver', 'local'));
    }

    protected function getPath(string $prefix, string $name): string
    {
        $path = config('unicon.cache.disk.path', '');

        return "$path/$prefix/$name.svg";
    }
}
