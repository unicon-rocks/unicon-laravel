<?php

declare(strict_types=1);

use Hedger\Unicon\Facades\Icon;

if (! function_exists('icon')) {
    /**
     * Renders an icon.
     * 
     * @param  string  $name  The name of the icon to render.
     * @return string The rendered icon.
     */
    function icon(string $name): string
    {
        return Icon::render($name);
    }
}
