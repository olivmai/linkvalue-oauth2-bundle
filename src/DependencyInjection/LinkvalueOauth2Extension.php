<?php

namespace Linkvalue\Oauth2Bundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\Extension;

class LinkvalueOauth2Extension extends Extension
{
    public function load(array $configs, ContainerBuilder $container)
    {
        $loader = new XmlFileLoader($container, new FileLocator(dirname(__DIR__).'/Resources/config'));
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