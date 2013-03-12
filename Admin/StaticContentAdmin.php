<?php

namespace Symfony\Cmf\Bundle\ContentBundle\Admin;

use Doctrine\ODM\PHPCR\DocumentManager;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\DoctrinePHPCRAdminBundle\Admin\Admin;
use Symfony\Cmf\Bundle\ContentBundle\Document\StaticContent;
use Symfony\Cmf\Bundle\MenuBundle\Document\MultilangMenuNode;

class StaticContentAdmin extends Admin
{
    protected $translationDomain = 'SymfonyCmfContentBundle';

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
        $formMapper
            ->with('Routes')
                ->add(
                    'routes',
                    'sonata_type_collection',
                    array(
                        'by_reference' => false
                    ),
                    array(
                        'edit' => 'inline',
                        'inline' => 'table',
                        'admin_code' => 'symfony_cmf_routing_extra.minimal_route_admin'
                    ))
            ->end()
            ->with('Menu')
                ->add(
                    'menus',
                    'sonata_type_collection',
                    array(
                        'by_reference' => false
                    ),
                    array(
                        'edit' => 'inline',
                        'inline' => 'table',
                        'admin_code' => 'symfony_cmf_menu.minimal.admin'
                    ))
            ->end()
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
            ->add('name',  'doctrine_phpcr_string')
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

    public function preUpdate($staticPage)
    {
        $this->setRouteContents($staticPage);
        $this->setMenuContents($staticPage);

        parent::preUpdate($staticPage);
    }

    public function prePersist($staticPage)
    {
        $this->setRouteContents($staticPage);
        $this->setMenuContents($staticPage);

        parent::prePersist($staticPage);
    }

    /**
     * @param $staticPage StaticContent
     */
    protected function setRouteContents($staticPage)
    {
        /**
         * @var $route \Symfony\Cmf\Bundle\RoutingExtraBundle\Document\Route
         */
        foreach ($staticPage->getRoutes() as $route) {
            $route->setRouteContent($staticPage);
            $route->setDefault('type', 'static_pages');
        }
    }

    /**
     * @param $staticPage StaticContent
     */
    protected function setMenuContents($staticPage)
    {
        /**
         * @var $menu MultilangMenuNode
         */
        foreach ($staticPage->getMenus() as $menu) {
            $menu->setContent($staticPage);
        }
    }
}
