<?php

namespace Tourze\FakeServerBundle\Tests\Integration;

use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\ResponseEvent;
use Symfony\Component\HttpKernel\HttpKernelInterface;
use Symfony\Component\HttpKernel\KernelEvents;
use Tourze\FakeServerBundle\EventSubscriber\RandomServerHeaderResponseSubscriber;

class FakeServerBundleIntegrationTest extends KernelTestCase
{
    protected static function getKernelClass(): string
    {
        return IntegrationTestKernel::class;
    }

    public function testServiceWiring(): void
    {
        self::bootKernel();
        $container = self::getContainer();

        $this->assertTrue($container->has(RandomServerHeaderResponseSubscriber::class));
        $subscriber = $container->get(RandomServerHeaderResponseSubscriber::class);
        $this->assertInstanceOf(RandomServerHeaderResponseSubscriber::class, $subscriber);
    }

    public function testEventSubscription(): void
    {
        self::bootKernel();
        $container = self::getContainer();
        $dispatcher = $container->get('event_dispatcher');

        $response = new Response();
        $event = new ResponseEvent(
            self::$kernel,
            new Request(),
            HttpKernelInterface::MAIN_REQUEST,
            $response
        );

        $dispatcher->dispatch($event, KernelEvents::RESPONSE);

        $this->assertTrue($response->headers->has('Server'));
    }
}
