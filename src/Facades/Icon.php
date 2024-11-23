<?php

declare(strict_types=1);

namespace Unicon\Facades;

use Unicon\IconRenderer;
use Illuminate\Support\Facades\Facade;

/**
 * @see Unicon\IconRenderer
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
