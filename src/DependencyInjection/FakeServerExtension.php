<?php

namespace Tourze\FakeServerBundle\DependencyInjection;

use Tourze\SymfonyDependencyServiceLoader\AutoExtension;

class FakeServerExtension extends AutoExtension
{
    protected function getConfigDir(): string
    {
        return __DIR__ . '/../Resources/config';
    }
}
