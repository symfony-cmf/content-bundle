<?php

/*
 * This file is part of the Symfony CMF package.
 *
 * (c) 2011-2017 Symfony CMF
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Cmf\Bundle\ContentBundle\Tests\Fixtures\App;

use Symfony\Cmf\Component\Testing\HttpKernel\TestKernel;
use Symfony\Component\Config\Loader\LoaderInterface;

class Kernel extends TestKernel
{
    protected function configure()
    {
        $this->requireBundleSets([
            'default',
            'phpcr_odm',
        ]);

        $contents = require $this->getKernelDir().'/config/bundles.php';
        foreach ($contents as $class => $envs) {
            if (isset($envs['all']) || isset($envs[$this->environment])) {
                if (!class_exists($class)) {
                    throw new \InvalidArgumentException(sprintf(
                        'Bundle class "%s" does not exist.',
                        $class
                    ));
                }

                $this->requiredBundles[$class] = new $class();
            }
        }
    }

    public function registerContainerConfiguration(LoaderInterface $loader)
    {
        $loader->load($this->getKernelDir().'/config/config.php');
    }
}
