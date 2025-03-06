<?php

namespace PrBundle\SymfonyBundle;

use Symfony\Component\DependencyInjection\Extension\ExtensionInterface;
use Symfony\Component\HttpKernel\Bundle\Bundle;
use PrBundle\SymfonyBundle\DependencyInjection\MyBundleExtension;

class PrSymfonyBundle extends Bundle
{
    public function getContainerExtension(): ?ExtensionInterface
    {
        return new PrBundleExtension();
    }
}
