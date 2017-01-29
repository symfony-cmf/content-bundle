<?php

/*
 * This file is part of the Symfony CMF package.
 *
 * (c) 2011-2017 Symfony CMF
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Cmf\Bundle\ContentBundle\Tests\Unit\Doctrine\Phpcr\Form\Type;

use Doctrine\ODM\PHPCR\Document\Generic;
use Doctrine\ODM\PHPCR\DocumentManager;
use Symfony\Cmf\Bundle\ContentBundle\Doctrine\Phpcr\Form\Type\StaticContentType;
use Symfony\Cmf\Bundle\ContentBundle\Doctrine\Phpcr\StaticContent;
use Symfony\Cmf\Bundle\TreeBrowserBundle\Form\Type\TreeSelectType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\PreloadedExtension;
use Symfony\Component\Form\Test\TypeTestCase;

class StaticContentTypeTest extends TypeTestCase
{
    private $documentManager;

    protected function setUp()
    {
        $this->documentManager = $this->getMockBuilder(DocumentManager::class)
            ->disableOriginalConstructor()
            ->getMock()
        ;
        parent::setUp();
    }

    protected function getExtensions()
    {
        $type = new StaticContentType($this->documentManager, '/cms/content');

        return [
            new PreloadedExtension([$type], []),
        ];
    }

    public function testSubmitValidData()
    {
        $data = [
            'name' => 'hello-world',
            'parentDocument' => '/cms/content',
        ];

        $document = $this->getMock(Generic::class);

        $this->documentManager->expects($this->once())
            ->method('find')
            ->with(null, $data['parentDocument'])
            ->will($this->returnValue($document));

        $form = $this->factory->create(StaticContentType::class);

        $form->submit($data);

        $object = new StaticContent();
        $object->setName($data['name']);
        $object->setParentDocument($document);

        $this->assertTrue($form->isSynchronized());
        $this->assertEquals($object, $form->getData());
    }

    public function testReadonlyParentDocument()
    {
        $builder = $this->factory->createBuilder(StaticContentType::class, null, [
            'readonly_parent_document' => true,
        ]);

        $this->assertInstanceof(
            TextType::class,
            $builder->get('parentDocument')->getForm()->getConfig()->getType()->getInnerType()
        );
        $this->assertTrue($builder->get('parentDocument')->getDisabled());
    }

    public function testWritableParentDocument()
    {
        $form = $this->factory->create(StaticContentType::class);
        $this->assertInstanceof(
            TreeSelectType::class,
            $form->get('parentDocument')->getConfig()->getType()->getInnerType()
        );
    }
}
