<?php

namespace Symfony\Cmf\Bundle\ContentBundle\Admin;

use Doctrine\ODM\PHPCR\DocumentManager;

use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\DoctrinePHPCRAdminBundle\Admin\Admin;

use Symfony\Cmf\Bundle\ContentBundle\Document\StaticContent;
use Symfony\Cmf\Bundle\MenuBundle\Document\MenuNode;
use Symfony\Cmf\Bundle\RoutingBundle\Document\Route;

class StaticContentAdmin extends Admin
{
    protected $translationDomain = 'CmfContentBundle';

    /**
     * Root path for the route content selection
     * @var string
     */
    protected $contentRoot;

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('path', 'text')
            ->add('title', 'text')
        ;
    }

    protected function configureFormFields(FormMapper $formMapper)
    {
        /** @var \Doctrine\ODM\PHPCR\Mapping\ClassMetadata $documentMetaData */
        $documentMetaData = $this->getModelManager()->getMetadata($this->getClass());

        $routesFieldName = 'routes';
        if ($documentMetaData->hasAssociation($routesFieldName)) {
            $routesAssociation = $documentMetaData->getAssociation($routesFieldName);
            if (null !== $this->getConfigurationPool()->getAdminByClass($routesAssociation['referringDocument'])) {
                $formMapper
                    ->with('form.group_routes')
                    ->add(
                    $routesFieldName,
                    'sonata_type_collection',
                    array(
                        'by_reference' => false
                    ),
                    array(
                        'edit' => 'inline',
                        'inline' => 'table',
                    )
                )
                    ->end()
                ;
            }
        }

        $menusFieldName = 'menus';
        if ($documentMetaData->hasAssociation($menusFieldName)) {
            $menuAssociation = $documentMetaData->getAssociation($menusFieldName);
            if (null !== $this->getConfigurationPool()->getAdminByClass($menuAssociation['referringDocument'])) {
                $formMapper
                    ->with('form.group_menus')
                    ->add(
                    $menusFieldName,
                    'sonata_type_collection',
                    array(
                        'by_reference' => false,
                    ),
                    array(
                        'edit' => 'inline',
                        'inline' => 'table',
                    )
                )
                    ->end()
                ;
            }
        }

        $formMapper
            ->with('form.group_general')
            ->add('parent', 'doctrine_phpcr_odm_tree', array('root_node' => $this->contentRoot, 'choice_list' => array(), 'select_root_node' => true))
            ->add('name', 'text')
            ->add('title', 'text')
            ->add('body', 'textarea', array('required' => false))
            ->end()
        ;
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('title', 'doctrine_phpcr_string')
            ->add('name',  'doctrine_phpcr_nodename')
        ;
    }

    public function getNewInstance()
    {
        /** @var $new StaticContent */
        $new = parent::getNewInstance();
        if ($this->hasRequest()) {
            $parentId = $this->getRequest()->query->get('parent');
            if (null !== $parentId) {
                $new->setParent($this->getModelManager()->find(null, $parentId));
            }
        }
        return $new;
    }

    public function setContentRoot($contentRoot)
    {
        $this->contentRoot = $contentRoot;
    }

    public function getExportFormats()
    {
        return array();
    }
}
