<?php

declare(strict_types=1);

namespace Hedger\Unicon\Test\Feature;

use Hedger\Unicon\Facades\Icon;
use Hedger\Unicon\IconRenderer;
use Hedger\Unicon\Test\TestCase;
use PHPUnit\Framework\Attributes\Test;

class IconFacadeTest extends TestCase
{
    #[Test]
    public function it_renders_the_icon()
    {
        $this->partialMock(IconRenderer::class)
            ->shouldReceive('render')
            ->once()
            ->andReturn($this->icon);

        $rendered = Icon::render('heroicons:clock');

        $this->assertXmlStringEqualsXmlString($this->icon, $rendered);
    }
}
