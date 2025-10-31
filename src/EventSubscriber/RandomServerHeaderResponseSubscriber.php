<?php

namespace Tourze\FakeServerBundle\EventSubscriber;

use Symfony\Component\EventDispatcher\Attribute\AsEventListener;
use Symfony\Component\HttpKernel\Event\ResponseEvent;
use Symfony\Component\HttpKernel\KernelEvents;

/**
 * 返回一个随机伪造的server，欺骗扫描器进行无效扫描
 */
class RandomServerHeaderResponseSubscriber
{
    /** @var array<string> */
    private array $servers = [
        'cloudflare',
        'Windows-Azure-Web/1.0',
        'Microsoft-HTTPAPI/2.0',
        'Tengine',
        'nginx',
        'marco/3.2',
        'JSP3/2.0.14',
        'Microsoft-IIS/10.0',
    ];

    #[AsEventListener(event: KernelEvents::RESPONSE)]
    public function onKernelResponse(ResponseEvent $event): void
    {
        if ($event->getResponse()->headers->has('Server')) {
            return;
        }

        // 获取一个随机值
        $server = $this->servers[array_rand($this->servers)];
        $event->getResponse()->headers->set('Server', $server);
    }
}
