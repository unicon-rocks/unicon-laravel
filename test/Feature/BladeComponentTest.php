<?php

declare(strict_types=1);

namespace Unicon\Test\Feature;

use Unicon\IconRenderer;
use Unicon\IconServiceProvider;
use Unicon\Test\TestCase;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Config;
use PHPUnit\Framework\Attributes\Test;

class BladeComponentTest extends TestCase
{
    #[Test]
    public function it_renders_the_icon()
    {
        $this->partialMock(IconRenderer::class)
            ->shouldReceive('render')
            ->once()
            ->andReturn($this->icon);

        $rendered = Blade::render('<x-icon name="heroicons:clock" />');

        $this->assertXmlStringEqualsXmlString($this->icon, $rendered);
    }

    #[Test]
    public function it_renders_the_icon_with_a_custom_name()
    {
        Config::set('unicon.name', 'iconify');
        $this->app->register(IconServiceProvider::class, force: true);

        $this->partialMock(IconRenderer::class)
            ->shouldReceive('render')
            ->once()
            ->andReturn($this->icon);

        $rendered = Blade::render('<x-iconify name="heroicons:clock" />');

        $this->assertXmlStringEqualsXmlString($this->icon, $rendered);
    }

    #[Test]
    public function it_forwards_attributes_to_the_svg_element()
    {
        $this->partialMock(IconRenderer::class)
            ->shouldReceive('render')
            ->once()
            ->andReturn($this->icon);

        $rendered = Blade::render('<x-icon name="heroicons:clock" data-slot="icon" />');

        $this->assertXmlStringEqualsXmlString(<<<'SVG'
        <svg data-slot="icon" xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24">
            <path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0a9 9 0 0 1 18 0"/>
        </svg>
        SVG, $rendered);
    }

    #[Test]
    public function it_merges_the_class_attribute_with_the_default_class_names()
    {
        config(['unicon.defaults.class' => 'w-6']);

        $this->partialMock(IconRenderer::class)
            ->shouldReceive('render')
            ->once()
            ->andReturn($this->icon);

        $rendered = Blade::render('<x-icon name="heroicons:clock" class="h-6" />');

        $this->assertXmlStringEqualsXmlString(<<<'SVG'
        <svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24">
            <path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0a9 9 0 0 1 18 0"/>
        </svg>
        SVG, $rendered);
    }
}
