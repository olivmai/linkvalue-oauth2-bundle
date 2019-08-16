<?php

namespace Olivmai\LinkvalueOAuth2Bundle\DependencyInjection;

use Symfony\Component\DependencyInjection\Dumper\XmlDumper;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;
use Symfony\Component\Config\FileLocator;

class LinkvalueOauth2Extension extends Extension
{
    public function load(array $configs, ContainerBuilder $container)
    {
        $loader = new XmlFileLoader(
            $container,
            new FileLocator(__DIR__.'/../Resources/config')
        );
        $loader->load('services.xml');

        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $definition = $container->getDefinition('linkvalue.oauth2.provider');
        $definition->replaceArgument(1, $config['client_id']);
        $definition->replaceArgument(2, $config['client_secret']);
        $definition->replaceArgument(3, $config['redirect_uri']);
        $definition->replaceArgument(4, $config['scopes']);
    }
}