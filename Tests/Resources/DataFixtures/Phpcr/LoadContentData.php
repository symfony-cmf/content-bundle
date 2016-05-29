<?php

/*
 * This file is part of the Symfony CMF package.
 *
 * (c) 2011-2015 Symfony CMF
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Cmf\Bundle\ContentBundle\Tests\Resources\DataFixtures\Phpcr;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\ODM\PHPCR\Document\Generic;
use PHPCR\Util\NodeHelper;
use Symfony\Cmf\Bundle\ContentBundle\Doctrine\Phpcr\StaticContent;
use Symfony\Cmf\Bundle\RoutingBundle\Doctrine\Phpcr\Route;

class LoadContentData implements FixtureInterface
{
    public function load(ObjectManager $manager)
    {
        NodeHelper::createPath($manager->getPhpcrSession(), '/test');
        $root = $manager->find(null, '/test');

        $contentRoot = new Generic();
        $contentRoot->setNodename('contents');
        $contentRoot->setParent($root);
        $manager->persist($contentRoot);

        $routeRoot = new Generic();
        $routeRoot->setNodename('routes');
        $routeRoot->setParent($root);
        $manager->persist($routeRoot);

        $content = new StaticContent();
        $content->setName('content-1');
        $content->setTitle('Content 1');
        $content->setBody('Content 1');
        $content->setParentDocument($contentRoot);
        $manager->persist($content);

        $route = new Route();
        $route->setContent($content);
        $route->setParentDocument($routeRoot);
        $route->setName('content-1');
        $manager->persist($route);

        $content = new StaticContent();
        $content->setName('content-2');
        $content->setTitle('Content 2');
        $content->setBody('Content 2');
        $content->setParentDocument($contentRoot);
        $manager->persist($content);

        $collection = new StaticContent();
        $collection->setName('collection');
        $collection->setTitle('Collection');
        $collection->setBody('Body of Collection');
        $collection->setParentDocument($contentRoot);
        $manager->persist($collection);

        $collectionRoute = new Route();
        $collectionRoute->setContent($collection);
        $collectionRoute->setParentDocument($routeRoot);
        $collectionRoute->setName('collection');
        $manager->persist($collectionRoute);



        $manager->flush();
    }
}
