<?php
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

        if (!empty($config['persistence']['phpcr']['enabled'])) {
            $this->loadPhpcr($config['persistence']['phpcr'], $loader, $container);
        }

        if (isset($config['multilang'])) {
            $container->setParameter($this->getAlias() . '.multilang.locales', $config['multilang']['locales']);
        }

        if (isset($config['default_template'])) {
            $container->setParameter($this->getAlias() . '.default_template', $config['default_template']);
        }
    }

    public function loadPhpcr($config, XmlFileLoader $loader, ContainerBuilder $container)
    {
        $keys = array(
            'document_class' => 'document.class',
            'manager_name' => 'manager_name',
            'content_basepath' => 'content_basepath',
        );

        foreach ($keys as $sourceKey => $targetKey) {
            if (isset($config[$sourceKey])) {
                $container->setParameter($this->getAlias() . '.persistence.phpcr.'.$targetKey, $config[$sourceKey]);
            }
        }

        if ($config['use_sonata_admin']) {
            $this->loadSonataAdmin($config, $loader, $container);
        }
    }

    public function loadSonataAdmin($config, XmlFileLoader $loader, ContainerBuilder $container, $prefix = '')
    {
        $bundles = $container->getParameter('kernel.bundles');
        if ('auto' === $config['use_sonata_admin'] && !isset($bundles['SonataDoctrinePHPCRAdminBundle'])) {
            return;
        }

        $loader->load('admin.xml');

        if (isset($config['admin_class'])) {
            $container->setParameter($this->getAlias() . '.' . $prefix . 'admin.class', $config['admin_class']);
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
