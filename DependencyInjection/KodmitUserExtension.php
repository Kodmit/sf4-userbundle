<?php

namespace Kodmit\UserBundle\DependencyInjection;

use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;

class KodmitUserExtension extends Extension
{
    public function load(array $configs, ContainerBuilder $container)
    {

        $containerBuilder = new ContainerBuilder();
        $loader = new YamlFileLoader($containerBuilder, new FileLocator(dirname( dirname(__DIR__ )) . "/Ressources/config/"));
        $loader->load('services.yaml');
    }

}