<?php

namespace Symfony\Cmf\Bundle\ContentBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class CmfContentBundle extends Bundle
{
    public function build(ContainerBuilder $container)
    {
        if (class_exists('Doctrine\Bundle\PHPCRBundle\DependencyInjection\Compiler\DoctrinePhpcrMappingsPass')) {
            $container->addCompilerPass(
                DoctrinePhpcrMappingsPass::createXmlMappingDriver(
                    array(
                        realpath(__DIR__ . '/Resources/config/doctrine-model') => 'Symfony\Cmf\Bundle\MenuBundle\Model',
                        realpath(__DIR__ . '/Resources/config/doctrine-phpcr') => 'Symfony\Cmf\Bundle\MenuBundle\Doctrine\Phpcr',
                    ),
                    array('cmf_menu.document_manager_name')
                )
            );
        }
    }
}
