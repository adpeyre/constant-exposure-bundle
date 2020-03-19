<?php

namespace ConstantExposureBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    public function getConfigTreeBuilder()
    {
        $rootName = 'constant_exposure';

        $treeBuilder = new TreeBuilder($rootName);
        $rootNode = method_exists($treeBuilder, 'getRootNode') ? $treeBuilder->getRootNode() : $treeBuilder->root($rootName);

        $rootNode
            ->children()
                ->arrayNode('parameter')
                    ->beforeNormalization()
                    ->always()
                    ->then(function ($v) {
                        $normalized = [];
                        foreach ((array)$v as $name => $value) {
                            $normalized[] = ['name' => $name, 'value' => $value];
                        }

                        return $normalized;
                    })
                    ->end()
                    ->arrayPrototype()
                        ->children()
                            ->scalarNode('name')
                                ->isRequired()
                                ->end()
                            ->scalarNode('value')
                                ->isRequired()
                                ->end()
                        ->end()
                    ->end()
                ->end();

        return $treeBuilder;
    }
}
