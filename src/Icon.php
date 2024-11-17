<?php

declare(strict_types=1);

namespace Hedger\Unicon;

use Closure;
use Illuminate\Support\Str;
use Illuminate\View\Component;

class Icon extends Component
{
    public function __construct(
        public IconRenderer $renderer,
        public string $name,
    ) {}

    /**
     * Renders the Icon component.
     */
    public function render(): Closure
    {
        return fn () => $this->injectAttributes($this->renderer->render($this->name));
    }

    /**
     * Injects the attributes into the SVG element.
     */
    protected function injectAttributes(string $svg): string
    {
        return Str::replace(
            search: '<svg ',
            replace: '<svg {{ $attributes->merge([\'class\' => config(\'unicon.defaults.class\') ?: null ]) }} ',
            subject: $svg,
        );
    }
}
