<?php

namespace Symfony\Cmf\Bundle\ContentBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();

        $treeBuilder->root('cmf_content')
            ->children()
                ->scalarNode('default_template')->defaultNull()->end()
                ->arrayNode('persistence')
                    ->children()
                        ->arrayNode('phpcr')
                            ->children()
                                ->scalarNode('admin_class')->defaultNull()->end()
                                ->scalarNode('document_class')->defaultNull()->end()
                                ->scalarNode('content_basepath')->defaultValue('/cms/content')->end()
                                ->enumNode('use_sonata_admin')
                                    ->values(array(true, false, 'auto'))
                                    ->defaultValue('auto')
                                ->end()
                            ->end()
                        ->end()
                    ->end()
                ->end()
                ->arrayNode('multilang')
                    ->fixXmlConfig('locale')
                    ->children()
                        ->arrayNode('locales')
                            ->isRequired()
                            ->requiresAtLeastOneElement()
                            ->prototype('scalar')->end()
                        ->end()
                    ->end()
                ->end()
            ->end()
        ;

        return $treeBuilder;
    }
}
