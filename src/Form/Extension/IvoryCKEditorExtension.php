<?php

/*
 * This file is part of the Symfony CMF package.
 *
 * (c) 2011-2017 Symfony CMF
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Cmf\Bundle\ContentBundle\Form\Extension;

use Ivory\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Cmf\Bundle\ContentBundle\Form\Type\StaticContentType;
use Symfony\Component\Form\AbstractTypeExtension;
use Symfony\Component\Form\FormBuilderInterface;

class IvoryCKEditorExtension extends AbstractTypeExtension
{
    /**
     * @var array
     */
    private $options;

    /**
     * @param array $options CKEditorType options
     *
     * @see CKEditorType
     */
    public function __construct(array $options)
    {
        $this->options = $options;
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('body', CKEditorType::class, $this->options);
    }

    /**
     * {@inheritdoc}
     */
    public function getExtendedType()
    {
        return StaticContentType::class;
    }
}
