<?php

/*
 * This file is part of the Symfony CMF package.
 *
 * (c) 2011-2016 Symfony CMF
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */


namespace Symfony\Cmf\Bundle\ContentBundle\Admin;

use Ivory\CKEditorBundle\Form\Type\CKEditorType;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\DoctrinePHPCRAdminBundle\Admin\Admin;
use Sonata\DoctrinePHPCRAdminBundle\Form\Type\TreeModelType;
use Symfony\Cmf\Bundle\ContentBundle\Model\StaticContentBase;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class StaticContentAdmin extends Admin
{
    protected $translationDomain = 'CmfContentBundle';

    private $ivoryCkeditor = array();

    public function setIvoryCkeditor($config)
    {
        $this->ivoryCkeditor = (array) $config;
    }

    public function getExportFormats()
    {
        return array();
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('id', 'text')
            ->addIdentifier('title', 'text')
        ;
    }

    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->with('form.group_general')
                ->add('parentDocument', TreeModelType::class, array(
                    'root_node' => $this->getRootPath(),
                    'choice_list' => array(),
                    'select_root_node' => true,
                ))
                ->add('name', TextType::class)
                ->add('title', TextType::class)
                ->add(
                    'body',
                    $this->ivoryCkeditor ? CKEditorType::class : TextareaType::class,
                    $this->ivoryCkeditor
                )
            ->end()
        ;
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('title', 'doctrine_phpcr_string')
            ->add('name', 'doctrine_phpcr_nodename')
        ;
    }

    public function toString($object)
    {
        return $object instanceof StaticContentBase && $object->getTitle()
            ? $object->getTitle()
            : $this->trans('link_add', array(), 'SonataAdminBundle')
        ;
    }
}
