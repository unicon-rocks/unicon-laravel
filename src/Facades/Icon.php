<?php

declare(strict_types=1);

namespace Hedger\Unicon\Facades;

use Hedger\Unicon\IconRenderer;
use Illuminate\Support\Facades\Facade;

/**
 * @see \Hedger\Unicon\IconRenderer
 * 
 * @method static string render(string $name) Renders the icon.
 */
class Icon extends Facade
{
    protected static function getFacadeAccessor()
    {
        return IconRenderer::class;
    }
}
