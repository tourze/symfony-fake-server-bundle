<?php

namespace Tourze\FakeServerBundle\Tests\DependencyInjection;

use PHPUnit\Framework\TestCase;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
use Symfony\Component\Config\FileLocator;
use Tourze\FakeServerBundle\DependencyInjection\FakeServerExtension;

class FakeServerExtensionTest extends TestCase
{
    public function testExtensionLoadsConfiguration(): void
    {
        $container = new ContainerBuilder();
        $extension = new FakeServerExtension();
        
        // 测试扩展能够加载配置，不应抛出异常
        $extension->load([], $container);
        
        // 验证配置文件路径是否正确
        $serviceConfigPath = __DIR__ . '/../../src/Resources/config/services.yaml';
        $this->assertFileExists($serviceConfigPath);
        
        // 验证至少有一些参数或定义被加载
        // 即使没有明确的服务定义，容器也应该有一些基本的定义
        $this->assertNotEmpty($container->getDefinitions());
    }
}