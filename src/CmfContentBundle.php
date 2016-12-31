<?php

/*
 * This file is part of the Symfony CMF package.
 *
 * (c) 2011-2017 Symfony CMF
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Cmf\Bundle\ContentBundle;

use Symfony\Cmf\Bundle\ContentBundle\DependencyInjection\Compiler\ValidationPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;
use Doctrine\Bundle\PHPCRBundle\DependencyInjection\Compiler\DoctrinePhpcrMappingsPass;

class CmfContentBundle extends Bundle
{
    public function build(ContainerBuilder $container)
    {
        $container->addCompilerPass(new ValidationPass());

        if (class_exists('Doctrine\Bundle\PHPCRBundle\DependencyInjection\Compiler\DoctrinePhpcrMappingsPass')) {
            $container->addCompilerPass(
                DoctrinePhpcrMappingsPass::createXmlMappingDriver(
                    array(
                        realpath(__DIR__.'/Resources/config/doctrine-model') => 'Symfony\Cmf\Bundle\ContentBundle\Model',
                        realpath(__DIR__.'/Resources/config/doctrine-phpcr') => 'Symfony\Cmf\Bundle\ContentBundle\Doctrine\Phpcr',
                    ),
                    array('cmf_content.persistence.phpcr.manager_name'),
                    'cmf_content.backend_type_phpcr',
                    array('CmfContentBundle' => 'Symfony\Cmf\Bundle\ContentBundle\Doctrine\Phpcr')
                )
            );
        }
    }
}
