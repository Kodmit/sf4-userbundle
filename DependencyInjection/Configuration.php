<?php
namespace Kodmit\UserBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * This is the class that validates and merges configuration from your app/config files
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html#cookbook-bundles-extension-config-class}
 */
class Configuration implements ConfigurationInterface
{
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('Kodmit\\UserBundle\\');

        $rootNode
            ->children()
            ->scalarNode('resource')->defaultValue('../../*')->end()
            ->arrayNode('tags')
            ->canBeUnset()->prototype('scalar')->end()->end()
            ->end()
        ;

        return $treeBuilder;
    }
}
