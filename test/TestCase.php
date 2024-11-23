<?php

declare(strict_types=1);

namespace Unicon\Test;

use Unicon\IconCache;

class TestCase extends \Orchestra\Testbench\TestCase
{
    protected string $icon = <<<'SVG'
    <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24">
        <path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0a9 9 0 0 1 18 0"/>
    </svg>
    SVG;

    protected function getPackageProviders($app): array
    {
        return [
            \Unicon\IconServiceProvider::class,
        ];
    }

    protected function tearDown(): void
    {
        app(IconCache::class)->clear();
        parent::tearDown();
    }
}
