<?php

/*
 * This file is part of the Symfony CMF package.
 *
 * (c) 2011-2017 Symfony CMF
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Cmf\Bundle\ContentBundle\Tests\Functional\Doctrine\Phpcr;

use Symfony\Cmf\Bundle\ContentBundle\Doctrine\Phpcr\StaticContent;
use Symfony\Cmf\Component\Testing\Functional\BaseTestCase;

class StaticContentTest extends BaseTestCase
{
    public function setUp()
    {
        $this->db('PHPCR')->createTestNode();
        $this->dm = $this->db('PHPCR')->getOm();
        $this->base = $this->dm->find(null, '/test');
    }

    public function testStaticContent()
    {
        $data = [
            'name' => 'test-node',
            'title' => 'test-title',
            'body' => 'test-body',
            'publishable' => false,
            'publishStartDate' => new \DateTime('2013-06-18'),
            'publishEndDate' => new \DateTime('2013-06-18'),
        ];

        $content = new StaticContent();
        $refl = new \ReflectionClass($content);

        $content->setParentDocument($this->base);

        foreach ($data as $key => $value) {
            $refl = new \ReflectionClass($content);
            $prop = $refl->getProperty($key);
            $prop->setAccessible(true);
            $prop->setValue($content, $value);
        }

        $this->dm->persist($content);
        $this->dm->flush();
        $this->dm->clear();

        $content = $this->dm->find(null, '/test/test-node');

        $this->assertNotNull($content);

        foreach ($data as $key => $value) {
            $prop = $refl->getProperty($key);
            $prop->setAccessible(true);
            $v = $prop->getValue($content);

            if (!is_object($value)) {
                $this->assertEquals($value, $v);
            }
        }

        // test publish start and end
        $publishStartDate = $content->getPublishStartDate();
        $publishEndDate = $content->getPublishEndDate();

        $this->assertInstanceOf('\DateTime', $publishStartDate);
        $this->assertInstanceOf('\DateTime', $publishEndDate);
        $this->assertEquals($data['publishStartDate']->format('Y-m-d'), $publishStartDate->format('Y-m-d'));
        $this->assertEquals($data['publishEndDate']->format('Y-m-d'), $publishEndDate->format('Y-m-d'));

        // test multi-lang
        $content->setLocale('fr');
        $this->dm->persist($content);
        $this->dm->flush();
        $this->dm->clear();

        $content = $this->dm->findTranslation(null, '/test/test-node', 'fr');
        $this->assertEquals('fr', $content->getLocale());
    }
}
