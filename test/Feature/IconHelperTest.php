<?php

declare(strict_types=1);

namespace Unicon\Test\Feature;

use Unicon\IconRenderer;
use Unicon\Test\TestCase;
use PHPUnit\Framework\Attributes\Test;

class IconHelperTest extends TestCase
{
    #[Test]
    public function it_renders_the_icon()
    {
        $this->partialMock(IconRenderer::class)
            ->shouldReceive('render')
            ->once()
            ->andReturn($this->icon);

        $rendered = \icon('heroicons:clock');

        $this->assertXmlStringEqualsXmlString($this->icon, $rendered);
    }
}
