<?php

/*
 * This file is part of the Symfony CMF package.
 *
 * (c) 2011-2014 Symfony CMF
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Cmf\Bundle\ContentBundle\Admin;

use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\DoctrinePHPCRAdminBundle\Admin\Admin;

use Symfony\Cmf\Bundle\ContentBundle\Model\StaticContentBase;

class StaticContentAdmin extends Admin
{
    protected $translationDomain = 'CmfContentBundle';

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
            ->tab('form.tab_general')
                ->with('form.group_location', array('class' => 'col-md-3'))
                    ->add('parent', 'doctrine_phpcr_odm_tree', array(
                        'root_node' => $this->getRootPath(),
                        'choice_list' => array(),
                        'select_root_node' => true)
                    )
                    ->add('name', 'text')
                ->end() // group location

                ->with('form.group_general', array('class' => 'col-md-9'))
                    ->add('title', 'text')
                    ->add('body', 'textarea', array(
                        'attr' => array(
                            'style' => 'height:200px'
                        ),
                    ))
                ->end() // group general
            ->end() // tab general
        ;
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('title', 'doctrine_phpcr_string')
            ->add('name',  'doctrine_phpcr_nodename')
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
