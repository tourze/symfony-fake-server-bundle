<?php

namespace Tourze\FakeServerBundle\Tests\EventSubscriber;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\RunTestsInSeparateProcesses;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\ResponseEvent;
use Symfony\Component\HttpKernel\HttpKernelInterface;
use Tourze\FakeServerBundle\EventSubscriber\RandomServerHeaderResponseSubscriber;
use Tourze\PHPUnitSymfonyKernelTest\AbstractEventSubscriberTestCase;

/**
 * @internal
 */
#[CoversClass(RandomServerHeaderResponseSubscriber::class)]
#[RunTestsInSeparateProcesses]
final class RandomServerHeaderResponseSubscriberTest extends AbstractEventSubscriberTestCase
{
    private RandomServerHeaderResponseSubscriber $subscriber;

    protected function onSetUp(): void
    {
        // 从容器中获取被测试的订阅者
        $this->subscriber = self::getService(RandomServerHeaderResponseSubscriber::class);
    }

    public function testOnKernelResponseWhenResponseHasNoServerHeader(): void
    {
        // 创建模拟对象
        $response = new Response();
        $responseEvent = $this->createResponseEvent($response);

        // 执行测试方法
        $this->subscriber->onKernelResponse($responseEvent);

        // 断言
        $this->assertTrue($response->headers->has('Server'));
        $this->assertContains(
            $response->headers->get('Server'),
            $this->getSubscriberServers($this->subscriber)
        );
    }

    public function testOnKernelResponseWhenResponseAlreadyHasServerHeader(): void
    {
        // 创建已有Server头的响应
        $response = new Response();
        $response->headers->set('Server', 'ExistingServer');
        $responseEvent = $this->createResponseEvent($response);

        // 执行测试方法
        $this->subscriber->onKernelResponse($responseEvent);

        // 断言Server头没有被修改
        $this->assertEquals('ExistingServer', $response->headers->get('Server'));
    }

    public function testOnKernelResponseRandomDistribution(): void
    {
        $servers = $this->getSubscriberServers($this->subscriber);
        $usedServers = [];
        $iterations = count($servers) * 10; // 足够多的迭代以确保覆盖所有服务器

        for ($i = 0; $i < $iterations; ++$i) {
            $response = new Response();
            $responseEvent = $this->createResponseEvent($response);

            $this->subscriber->onKernelResponse($responseEvent);

            $usedServers[$response->headers->get('Server')] = true;
        }

        // 断言所有预定义的服务器都被使用了
        foreach ($servers as $server) {
            $this->assertArrayHasKey($server, $usedServers, "服务器 '{$server}' 没有在随机分布中出现");
        }
    }

    private function createResponseEvent(Response $response): ResponseEvent
    {
        return new ResponseEvent(
            $this->createMock(HttpKernelInterface::class),
            new Request(),
            HttpKernelInterface::MAIN_REQUEST,
            $response
        );
    }

    /** @return array<string> */
    private function getSubscriberServers(RandomServerHeaderResponseSubscriber $subscriber): array
    {
        $reflection = new \ReflectionClass($subscriber);
        $property = $reflection->getProperty('servers');
        $property->setAccessible(true);

        return $property->getValue($subscriber);
    }
}
