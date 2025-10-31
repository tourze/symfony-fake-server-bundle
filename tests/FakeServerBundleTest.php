<?php

declare(strict_types=1);

namespace FakeServerBundle\Tests;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\RunTestsInSeparateProcesses;
use Tourze\FakeServerBundle\FakeServerBundle;
use Tourze\PHPUnitSymfonyKernelTest\AbstractBundleTestCase;

/**
 * @internal
 */
#[CoversClass(FakeServerBundle::class)]
#[RunTestsInSeparateProcesses]
final class FakeServerBundleTest extends AbstractBundleTestCase
{
}
