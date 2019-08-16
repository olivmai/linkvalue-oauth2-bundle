<?php

namespace Olivmai\LinkvalueOAuth2Bundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder('linkvalue_oauth2');

        $treeBuilder->getRootNode()
            ->children()
                ->scalarNode('client_id')->end()
                ->scalarNode('client_secret')->end()
                ->scalarNode('redirect_uri')->end()
                ->arrayNode('scopes')->end()
            ->end()
        ;

        return $treeBuilder;
    }
}