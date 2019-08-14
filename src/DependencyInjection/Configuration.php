<?php

namespace Linkvalue\Oauth2Bundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder('linkvalue_oauth2');

        $treeBuilder->getRootNode()
            ->children()
                ->scalarNode('client_id')
                ->scalarNode('client_secret')
                ->scalarNode('redirect_uri')
                ->arrayNode('scopes')
            ->end()
        ;

        return $treeBuilder;
    }
}