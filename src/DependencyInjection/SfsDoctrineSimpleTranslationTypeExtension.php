<?php

namespace Softspring\DoctrineSimpleTranslationTypeBundle\DependencyInjection;

use Softspring\DoctrineSimpleTranslationTypeBundle\Doctrine\Type\SimpleTranslationType;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\PrependExtensionInterface;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;

class SfsDoctrineSimpleTranslationTypeExtension extends Extension implements PrependExtensionInterface
{
    public function load(array $configs, ContainerBuilder $container)
    {
        $loader = new YamlFileLoader($container, new FileLocator(__DIR__.'/../../config/services'));
        $loader->load('twig_extension.yaml');
        $loader->load('type_guesser.yaml');
    }

    public function prepend(ContainerBuilder $container)
    {
        $doctrineConfig = [];

        // add custom doctrine type
        $doctrineConfig['dbal']['types']['simple_translation'] = SimpleTranslationType::class;

        $container->prependExtensionConfig('doctrine', $doctrineConfig);
    }
}
