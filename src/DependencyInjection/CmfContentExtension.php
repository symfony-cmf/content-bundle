<?php

/*
 * This file is part of the Symfony CMF package.
 *
 * (c) 2011-2016 Symfony CMF
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Cmf\Bundle\ContentBundle\DependencyInjection;

use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;
use Symfony\Component\Config\FileLocator;

class CmfContentExtension extends Extension
{
    public function load(array $configs, ContainerBuilder $container)
    {
        $config = $this->processConfiguration(new Configuration(), $configs);

        $loader = new XmlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.xml');

        if ($config['persistence']['phpcr']['enabled']) {
            $this->loadPhpcr($config['persistence']['phpcr'], $loader, $container);
        }

        if (isset($config['default_template'])) {
            $container->setParameter($this->getAlias().'.default_template', $config['default_template']);
        }

        if ($this->isIvoryCKEditorEnabled($config['ivory_ckeditor'], $container)) {
            $loader->load('ivory-ckeditor.xml');
            $container->setParameter($this->getAlias().'.ivory_ckeditor.config', [
                'config_name' => $config['ivory_ckeditor']['config_name'],
            ]);
        }
    }

    private function isIvoryCKEditorEnabled(array $config, ContainerBuilder $container)
    {
        $bundles = $container->getParameter('kernel.bundles');

        // Explicitely disabled
        if (false === $config['enabled']) {
            return false;
        }

        // Explicitely enabled but not available
        if (true === $config['enabled'] && !isset($bundles['IvoryCKEditorBundle'])) {
            $message = 'IvoryCKEditorBundle integration was explicitely enabled, but the bundle is not available';

            if (class_exists('Ivory\CKEditorBundle\IvoryCKEditorBundle')) {
                $message .= ' (did you forget to register the bundle in the AppKernel?)';
            }

            throw new \LogicException($message.'.');
        }

        return isset($bundles['IvoryCKEditorBundle']);
    }

    public function loadPhpcr(array $config, XmlFileLoader $loader, ContainerBuilder $container)
    {
        $container->setParameter($this->getAlias().'.backend_type_phpcr', true);

        $keys = array(
            'manager_name',
            'content_basepath',
        );

        foreach ($keys as $key) {
            $container->setParameter($this->getAlias().'.persistence.phpcr.'.$key, $config[$key]);
        }

        $loader->load('persistence-phpcr.xml');
        $loader->load('forms-phpcr.xml');
    }

    /**
     * Returns the base path for the XSD files.
     *
     * @return string The XSD base path
     */
    public function getXsdValidationBasePath()
    {
        return __DIR__.'/../Resources/config/schema';
    }

    public function getNamespace()
    {
        return 'http://cmf.symfony.com/schema/dic/content';
    }
}
