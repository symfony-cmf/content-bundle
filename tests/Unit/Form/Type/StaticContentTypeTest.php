<?php

/*
 * This file is part of the Symfony CMF package.
 *
 * (c) 2011-2017 Symfony CMF
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Cmf\Bundle\ContentBundle\Tests\Unit\Form\Type;

use Symfony\Cmf\Bundle\ContentBundle\Form\Type\StaticContentType;
use Symfony\Cmf\Bundle\ContentBundle\Model\StaticContent;
use Symfony\Component\Form\Test\TypeTestCase;

class StaticContentTypeTest extends TypeTestCase
{
    public function testSubmitValidData()
    {
        $data = [
            'title' => 'Hello World!',
            'body' => '<p>Lorem ipsum dolor sit amet.</p>',
        ];

        $form = $this->factory->create(StaticContentType::class);

        $form->submit($data);

        $object = new StaticContent();
        $object->setTitle($data['title']);
        $object->setBody($data['body']);

        $this->assertTrue($form->isSynchronized());
        $this->assertEquals($object, $form->getData());
    }
}
