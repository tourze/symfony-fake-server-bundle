<?php

namespace Tourze\FakeServerBundle\Tests\Unit;

use PHPUnit\Framework\TestCase;
use Tourze\FakeServerBundle\FakeServerBundle;

class FakeServerBundleTest extends TestCase
{
    public function testInstantiation(): void
    {
        $bundle = new FakeServerBundle();
        $this->assertInstanceOf(FakeServerBundle::class, $bundle);
    }
}