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

use Doctrine\Bundle\PHPCRBundle\DependencyInjection\Compiler\DoctrinePhpcrMappingsPass;
use Symfony\Cmf\Bundle\ContentBundle\DependencyInjection\Compiler\ValidationPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class CmfContentBundle extends Bundle
{
    public function build(ContainerBuilder $container)
    {
        $container->addCompilerPass(new ValidationPass());

        if (class_exists('Doctrine\Bundle\PHPCRBundle\DependencyInjection\Compiler\DoctrinePhpcrMappingsPass')) {
            $container->addCompilerPass(
                DoctrinePhpcrMappingsPass::createXmlMappingDriver(
                    [
                        realpath(__DIR__.'/Resources/config/doctrine-model') => 'Symfony\Cmf\Bundle\ContentBundle\Model',
                        realpath(__DIR__.'/Resources/config/doctrine-phpcr') => 'Symfony\Cmf\Bundle\ContentBundle\Doctrine\Phpcr',
                    ],
                    ['cmf_content.persistence.phpcr.manager_name'],
                    'cmf_content.backend_type_phpcr',
                    ['CmfContentBundle' => 'Symfony\Cmf\Bundle\ContentBundle\Doctrine\Phpcr']
                )
            );
        }
    }
}
