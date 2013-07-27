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

        $keys = array(
            'document_class', 
            'document_manager_name', 
            'default_template',
            'content_basepath',
            'static_basepath',
        );

        foreach ($keys as $key) {
            if (isset($config[$key])) {
                $container->setParameter($this->getAlias() . '.'.$key, $config[$key]);
            }
        }

        if ($config['use_sonata_admin']) {
            $this->loadSonataAdmin($config, $loader, $container);
        }

        if (isset($config['multilang'])) {
            $container->setParameter($this->getAlias() . '.multilang.locales', $config['multilang']['locales']);
        }
    }

    public function loadSonataAdmin($config, XmlFileLoader $loader, ContainerBuilder $container)
    {
        $bundles = $container->getParameter('kernel.bundles');
        if ('auto' === $config['use_sonata_admin'] && !isset($bundles['SonataDoctrinePHPCRAdminBundle'])) {
            return;
        }
        
        $loader->load('admin.xml');

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
