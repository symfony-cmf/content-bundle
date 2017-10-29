<?php

/*
 * This file is part of the Symfony CMF package.
 *
 * (c) 2011-2017 Symfony CMF
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Cmf\Bundle\ContentBundle\Tests\App;

use Knp\Bundle\MenuBundle\KnpMenuBundle;
use Symfony\Cmf\Bundle\ContentBundle\CmfContentBundle;
use Symfony\Cmf\Bundle\CoreBundle\CmfCoreBundle;
use Symfony\Cmf\Bundle\MenuBundle\CmfMenuBundle;
use Symfony\Cmf\Bundle\RoutingBundle\CmfRoutingBundle;
use Symfony\Cmf\Component\Testing\HttpKernel\TestKernel;
use Symfony\Component\Config\Loader\LoaderInterface;

class AppKernel extends TestKernel
{
    public function configure()
    {
        $this->requireBundleSets([
            'default',
            'phpcr_odm',
        ]);

        $this->addBundles([
            new KnpMenuBundle(),
            new CmfContentBundle(),
            new CmfRoutingBundle(),
            new CmfMenuBundle(),
            new CmfCoreBundle(),
        ]);
    }

    public function registerContainerConfiguration(LoaderInterface $loader)
    {
        $loader->load(__DIR__.'/config/config.php');
    }
}
