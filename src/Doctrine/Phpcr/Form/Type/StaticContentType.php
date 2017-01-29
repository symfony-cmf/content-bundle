<?php

/*
 * This file is part of the Symfony CMF package.
 *
 * (c) 2011-2017 Symfony CMF
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Cmf\Bundle\ContentBundle\Doctrine\Phpcr\Form\Type;

use Doctrine\Bundle\PHPCRBundle\Form\DataTransformer\DocumentToPathTransformer;
use Doctrine\ODM\PHPCR\DocumentManager;
use Symfony\Cmf\Bundle\ContentBundle\Doctrine\Phpcr\StaticContent;
use Symfony\Cmf\Bundle\ContentBundle\Form\Type\StaticContentType as ModelStaticContentType;
use Symfony\Cmf\Bundle\TreeBrowserBundle\Form\Type\TreeSelectType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class StaticContentType extends AbstractType
{
    /**
     * @var DocumentManager
     */
    private $documentManager;

    /**
     * @var string
     */
    private $contentBasePath;

    /**
     * @param DocumentManager $documentManager
     * @param string          $contentBasePath
     */
    public function __construct(DocumentManager $documentManager, $contentBasePath)
    {
        $this->documentManager = $documentManager;
        $this->contentBasePath = $contentBasePath;
    }

    /**
     * Builds the form.
     *
     * @see FormTypeInterface::buildForm()
     *
     * Available options:
     *     - readonly_parent_document bool use a disabled text field for parentDocument
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('name', TextType::class);

        if ($options['readonly_parent_document']) {
            $builder->add('parentDocument', TextType::class, [
                'disabled' => true,
            ]);
        } else {
            $builder->add('parentDocument', TreeSelectType::class, [
                'widget' => 'browser',
                'root_node' => $this->contentBasePath,
            ]);
        }

        $builder->get('parentDocument')
            ->addModelTransformer(new DocumentToPathTransformer($this->documentManager))
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => StaticContent::class,
            'readonly_parent_document' => false,
        ]);
        $resolver->addAllowedTypes('readonly_parent_document', 'bool');
    }

    /**
     * {@inheritdoc}
     */
    public function getParent()
    {
        return ModelStaticContentType::class;
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'cmf_content_phpcr_static_content';
    }
}
