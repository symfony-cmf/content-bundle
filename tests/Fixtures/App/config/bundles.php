<?php

/*
 * This file is part of the Symfony CMF package.
 *
 * (c) 2011-2017 Symfony CMF
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

use Knp\Bundle\MenuBundle\KnpMenuBundle;
use Symfony\Cmf\Bundle\ContentBundle\CmfContentBundle;
use Symfony\Cmf\Bundle\CoreBundle\CmfCoreBundle;
use Symfony\Cmf\Bundle\MenuBundle\CmfMenuBundle;
use Symfony\Cmf\Bundle\RoutingBundle\CmfRoutingBundle;

return [
    KnpMenuBundle::class => ['phpcr' => true],
    CmfContentBundle::class => ['phpcr' => true],
    CmfRoutingBundle::class => ['phpcr' => true],
    CmfMenuBundle::class => ['phpcr' => true],
    CmfCoreBundle::class => ['phpcr' => true],
];
