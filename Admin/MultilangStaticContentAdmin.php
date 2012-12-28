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
            ->add('locales', 'choice', array('template' => 'SonataDoctrinePHPCRAdminBundle:CRUD:locales.html.twig'))
        ;
    }

    protected function configureFormFields(FormMapper $formMapper)
    {
        $locales = $this->getConfigurationPool()->getContainer()->getParameter('symfony_cmf_content.locales');

        $formMapper
            ->with('General')
            ->add('locale', 'choice', array(
                'choices' => array_combine($locales, $locales),
                'empty_value' => '',
            ))
            ->end()
        ;

        parent::configureFormFields($formMapper);
    }
}
