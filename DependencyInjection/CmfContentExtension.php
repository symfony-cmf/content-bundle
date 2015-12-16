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

        $this->loadIvoryCKEditor($config['ivory_ckeditor'], $container);
    }

    protected function loadIvoryCKEditor(array $config, ContainerBuilder $container)
    {
        $container->setParameter($this->getAlias().'.ivory_ckeditor.config', array());

        $bundles = $container->getParameter('kernel.bundles');
        if ('auto' === $config['enabled'] && !isset($bundles['IvoryCKEditorBundle'])) {
            return;
        }

        if (true === $config['enabled'] && !isset($bundles['IvoryCKEditorBundle'])) {
            $message = 'IvoryCKEditorBundle integration was explicitely enabled, but the bundle is not available';

            if (class_exists('Ivory\CKEditorBundle\IvoryCKEditorBundle')) {
                $message .= ' (did you forget to register the bundle in the AppKernel?)';
            }

            throw new \LogicException($message.'.');
        }

        if (false === $config['enabled'] || !isset($bundles['IvoryCKEditorBundle'])) {
            return;
        }

        $container->setParameter($this->getAlias().'.ivory_ckeditor.config', array(
            'config_name' => $config['config_name'],
        ));
    }

    public function loadPhpcr($config, XmlFileLoader $loader, ContainerBuilder $container)
    {
        $container->setParameter($this->getAlias().'.backend_type_phpcr', true);

        $keys = array(
            'document_class' => 'document.class',
            'admin_class' => 'admin.class',
            'manager_name' => 'manager_name',
            'content_basepath' => 'content_basepath',
        );

        foreach ($keys as $sourceKey => $targetKey) {
            if (isset($config[$sourceKey])) {
                $container->setParameter($this->getAlias().'.persistence.phpcr.'.$targetKey, $config[$sourceKey]);
            }
        }

        $loader->load('persistence-phpcr.xml');

        if ($config['use_sonata_admin']) {
            $this->loadSonataAdmin($config, $loader, $container);
        }
    }

    public function loadSonataAdmin($config, XmlFileLoader $loader, ContainerBuilder $container)
    {
        $bundles = $container->getParameter('kernel.bundles');
        if ('auto' === $config['use_sonata_admin'] && !isset($bundles['SonataDoctrinePHPCRAdminBundle'])) {
            return;
        }

        $loader->load('admin.xml');
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
