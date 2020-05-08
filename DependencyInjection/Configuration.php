<?php

namespace LSB\NumberingBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * This is the class that validates and merges configuration from your app/config files.
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/configuration.html}
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritdoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder('lsb_numbering');

        $rootNode = $treeBuilder->getRootNode();
        $rootNode
            ->children()
                // patterns
                ->arrayNode('patterns')
                    ->arrayPrototype()
                        ->children()
                            ->scalarNode('name')->end()
                            ->scalarNode('pattern')->end()
                        ->end()
                    ->end()
                ->end()


                // counter_configs
                ->arrayNode('counter_configs')
                    ->arrayPrototype()
                        ->children()
                            ->scalarNode('name')->end()
                            ->scalarNode('patternName')->end()
                            ->scalarNode('start')->end()
                            ->scalarNode('step')->end()
                            ->scalarNode('time_context')->end() //TODO ograniczenie zestawu wartości, enum?
                            ->scalarNode('context_object_fqcn')->end()
                        ->end()
                    ->end()
                ->end()

            ->end();

        return $treeBuilder;
    }
}
