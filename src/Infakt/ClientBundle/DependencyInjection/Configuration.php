<?php

namespace Infakt\ClientBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritdoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('infakt_client');

        $rootNode
            ->children()
                ->scalarNode('api_key')->isRequired()
            ->end();

        return $treeBuilder;
    }
}
