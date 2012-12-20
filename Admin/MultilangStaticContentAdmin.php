<?php

namespace Symfony\Cmf\Bundle\ContentBundle\Admin;

use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;

class MultilangStaticContentAdmin extends StaticContentAdmin
{
    protected function configureListFields(ListMapper $listMapper)
    {
        parent::configureListFields($listMapper);
        $listMapper
            ->add('locale', 'text')
        ;
    }

    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->with('General')
            ->add('locale', 'text')
            ->end()
        ;

        parent::configureFormFields($formMapper);
    }
}
