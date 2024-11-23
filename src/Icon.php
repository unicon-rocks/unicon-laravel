<?php

declare(strict_types=1);

namespace Unicon;

use Closure;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Str;
use Illuminate\View\Component;
use PHPUnit\Framework\TestSize\Unknown;

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
        return function () {

            $svg = $this->name ? $this->renderer->render($this->name) : '';

            if (!$svg) {
                if (!App::environment(['production'])) {
                    throw new UnknownIconException($this->name);
                }
                return '';
            }

            return $this->injectAttributes($svg);
        };
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
