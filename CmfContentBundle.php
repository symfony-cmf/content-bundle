<?php

namespace Symfony\Cmf\Bundle\ContentBundle;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;
use Doctrine\Bundle\PHPCRBundle\DependencyInjection\Compiler\DoctrinePhpcrMappingsPass;

class CmfContentBundle extends Bundle
{
    public function build(ContainerBuilder $container)
    {
        if (class_exists('Doctrine\Bundle\PHPCRBundle\DependencyInjection\Compiler\DoctrinePhpcrMappingsPass')) {
            $container->addCompilerPass(
                DoctrinePhpcrMappingsPass::createXmlMappingDriver(
                    array(
                        realpath(__DIR__ . '/Resources/config/doctrine-model') => 'Symfony\Cmf\Bundle\ContentBundle\Model',
                        realpath(__DIR__ . '/Resources/config/doctrine-phpcr') => 'Symfony\Cmf\Bundle\ContentBundle\Doctrine\Phpcr',
                    ),
                    array('cmf_content.manager_name')
                )
            );
        }
    }
}
