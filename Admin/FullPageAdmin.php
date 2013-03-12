<?php

namespace Symfony\Cmf\Bundle\ContentBundle\Admin;

use Doctrine\ODM\PHPCR\DocumentManager;
use Sonata\AdminBundle\Form\FormMapper;
use Symfony\Cmf\Bundle\ContentBundle\Admin\MultilangStaticContentAdmin;
use Symfony\Cmf\Bundle\ContentBundle\Document\MultilangStaticContent;
use Symfony\Cmf\Bundle\MenuBundle\Document\MultilangMenuNode;

class FullPageAdmin extends MultilangStaticContentAdmin
{
    /**
     * @var DocumentManager
     */
    protected $dm;

    /**
     * @param string          $code
     * @param string          $class
     * @param string          $baseControllerName
     * @param array           $locales
     * @param DocumentManager $dm
     */
    public function __construct($code, $class, $baseControllerName, $locales, $dm)
    {
        $this->dm = $dm;

        parent::__construct($code, $class, $baseControllerName, $locales);
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
                    )
                )
            ->end();

        parent::configureFormFields($formMapper);

    }

    public function preUpdate($staticPage)
    {
        $this->persistRoutes($staticPage->getRoutes());
        $this->persistMenus($staticPage->getMenus());

        $this->setRouteContents($staticPage);
        $this->setMenuContents($staticPage);

        parent::preUpdate($staticPage);
    }

    public function prePersist($staticPage)
    {
        $this->persistRoutes($staticPage->getRoutes());
        $this->persistMenus($staticPage->getMenus());

        $this->setRouteContents($staticPage);
        $this->setMenuContents($staticPage);

        parent::prePersist($staticPage);
    }

    protected function persistRoutes($routes)
    {
        foreach ($routes as $route) {
            //TODO: remove the manual persist as soon as phpcr can persist referrers automatically
            $this->dm->persist($route);
        }
    }

    protected function persistMenus($menus)
    {
        foreach ($menus as $menu) {
            //TODO: remove the manual persist as soon as phpcr can persist referrers automatically
            $this->dm->persist($menu);
        }
    }

    /**
     * @param $staticPage MultilangStaticContent
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
     * @param $staticPage MultilangStaticContent
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
