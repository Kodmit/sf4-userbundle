<?php

namespace Kodmit\UserBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('services');

        $rootNode
            ->children()
                ->arrayNode('Kodmit\\UserBundle\\')
                    ->children()
                        ->scalarNode('test')->defaultValue("ok")->end()
                    ->end()
                ->end()
            ->end()
        ;

        return $treeBuilder;
    }
}