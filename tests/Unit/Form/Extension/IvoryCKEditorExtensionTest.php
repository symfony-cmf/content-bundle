<?php

/*
 * This file is part of the Symfony CMF package.
 *
 * (c) 2011-2017 Symfony CMF
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Cmf\Bundle\ContentBundle\Tests\Unit\Form\Extension;

use Ivory\CKEditorBundle\Form\Type\CKEditorType;
use Ivory\CKEditorBundle\Model\ConfigManagerInterface;
use Ivory\CKEditorBundle\Model\PluginManagerInterface;
use Ivory\CKEditorBundle\Model\StylesSetManagerInterface;
use Ivory\CKEditorBundle\Model\TemplateManagerInterface;
use Symfony\Cmf\Bundle\ContentBundle\Form\Extension\IvoryCKEditorExtension;
use Symfony\Cmf\Bundle\ContentBundle\Form\Type\StaticContentType;
use Symfony\Component\Form\PreloadedExtension;
use Symfony\Component\Form\Test\TypeTestCase;

class IvoryCKEditorExtensionTest extends TypeTestCase
{
    protected function getExtensions()
    {
        $type = new CKEditorType(
            $this->getMock(ConfigManagerInterface::class),
            $this->getMock(PluginManagerInterface::class),
            $this->getMock(StylesSetManagerInterface::class),
            $this->getMock(TemplateManagerInterface::class)
        );
        $extension = new IvoryCKEditorExtension([]);

        return [
            new PreloadedExtension([$type], [StaticContentType::class => [$extension]]),
        ];
    }

    public function testOverrideBody()
    {
        $form = $this->factory->create(StaticContentType::class);
        $this->assertInstanceOf(CKEditorType::class, $form->get('body')->getConfig()->getType()->getInnerType());
    }
}
