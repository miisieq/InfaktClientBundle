<?php

declare(strict_types=1);

namespace Infakt\ClientBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritdoc}
     */
    public function getConfigTreeBuilder(): TreeBuilder
    {
        $treeBuilder = new TreeBuilder('infakt_client');

        $treeBuilder->getRootNode()
            ->children()
                ->scalarNode('api_key')->isRequired()
            ->end()
        ;

        return $treeBuilder;
    }
}
