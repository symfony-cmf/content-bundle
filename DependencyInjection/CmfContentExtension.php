<?php
namespace Symfony\Cmf\Bundle\ContentBundle\DependencyInjection;

use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\Config\Definition\Processor;

class CmfContentExtension extends Extension
{
    public function load(array $configs, ContainerBuilder $container)
    {
        $config = $this->processConfiguration(new Configuration(), $configs);

        $loader = new XmlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.xml');

        if ($config['use_sonata_admin']) {
            $this->loadSonataAdmin($config, $loader, $container);
        }

        if (isset($config['multilang'])) {
            if ($config['multilang']['use_sonata_admin']) {
                $this->loadSonataAdmin($config['multilang'], $loader, $container, 'multilang.');
            }
            if (isset($config['multilang']['document_class'])) {
                $container->setParameter($this->getAlias() . '.multilang.document_class', $config['multilang']['document_class']);
            }

            $container->setParameter($this->getAlias() . '.multilang.locales', $config['multilang']['locales']);
        }

        if (isset($config['document_class'])) {
            $container->setParameter($this->getAlias() . '.document_class', $config['document_class']);
        }
        if (isset($config['default_template'])) {
            $container->setParameter($this->getAlias() . '.default_template', $config['default_template']);
        }

        $container->setParameter($this->getAlias() . '.content_basepath', $config['content_basepath']);
        $container->setParameter($this->getAlias() . '.static_basepath', $config['static_basepath']);
    }

    public function loadSonataAdmin($config, XmlFileLoader $loader, ContainerBuilder $container, $prefix = '')
    {
        $bundles = $container->getParameter('kernel.bundles');
        if ('auto' === $config['use_sonata_admin'] && !isset($bundles['SonataDoctrinePHPCRAdminBundle'])) {
            return;
        }
        
        $loader->load($prefix . 'admin.xml');

        if (isset($config['admin_class'])) {
            $container->setParameter($this->getAlias() . '.' . $prefix . 'admin_class', $config['admin_class']);
        }
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
