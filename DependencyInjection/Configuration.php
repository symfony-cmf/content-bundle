<?php

/*
 * This file is part of the Symfony CMF package.
 *
 * (c) 2011-2015 Symfony CMF
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

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
                ->scalarNode('default_template')->end()
                ->arrayNode('persistence')
                    ->addDefaultsIfNotSet()
                    ->children()
                        ->arrayNode('phpcr')
                            ->addDefaultsIfNotSet()
                            ->canBeEnabled()
                            ->children()
                                ->scalarNode('admin_class')->defaultValue('Symfony\Cmf\Bundle\ContentBundle\Admin\StaticContentAdmin')->end()
                                ->scalarNode('document_class')->defaultValue('Symfony\Cmf\Bundle\ContentBundle\Doctrine\Phpcr\StaticContent')->end()
                                ->scalarNode('content_basepath')->defaultValue('/cms/content')->end()
                                ->enumNode('use_sonata_admin')
                                    ->values(array(true, false, 'auto'))
                                    ->defaultValue('auto')
                                ->end()
                            ->end()
                        ->end()
                    ->end()
                ->end()
                ->arrayNode('ivory_ckeditor')
                    ->addDefaultsIfNotSet()
                    ->treatFalseLike(array('enabled' => false))
                    ->treatTrueLike(array('enabled' => true))
                    ->treatNullLike(array('enabled' => 'auto'))
                    ->children()
                        ->enumNode('enabled')
                            ->values(array(true, false, 'auto'))
                            ->defaultValue('auto')
                        ->end()
                        ->scalarNode('config_name')->defaultValue('cmf_content')->end()
                    ->end()
                ->end()
            ->end()
        ;

        return $treeBuilder;
    }
}
