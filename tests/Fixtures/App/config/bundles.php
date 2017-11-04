<?php

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