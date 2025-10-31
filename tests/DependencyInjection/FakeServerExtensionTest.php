<?php

namespace Tourze\FakeServerBundle\Tests\DependencyInjection;

use PHPUnit\Framework\Attributes\CoversClass;
use Tourze\FakeServerBundle\DependencyInjection\FakeServerExtension;
use Tourze\PHPUnitSymfonyUnitTest\AbstractDependencyInjectionExtensionTestCase;

/**
 * @internal
 */
#[CoversClass(FakeServerExtension::class)]
final class FakeServerExtensionTest extends AbstractDependencyInjectionExtensionTestCase
{
    protected function setUp(): void
    {
        // Extension 测试不需要特殊的设置
    }

    public function testLoad(): void
    {
        // 验证配置文件路径是否正确
        $serviceConfigPath = __DIR__ . '/../../Resources/config/services.yaml';
        $this->assertFileExists($serviceConfigPath);

        // 测试扩展是否正确加载
        $extension = new FakeServerExtension();
        $this->assertInstanceOf(FakeServerExtension::class, $extension);
        $this->assertEquals('fake_server', $extension->getAlias());
    }
}
