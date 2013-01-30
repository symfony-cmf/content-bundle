<?php

namespace Symfony\Cmf\Bundle\ContentBundle\Document;

use Doctrine\ODM\PHPCR\Mapping\Annotations as PHPCRODM;
use Doctrine\Common\Collections\ArrayCollection;

use Symfony\Cmf\Component\Routing\RouteAwareInterface;
use Symfony\Cmf\Bundle\CoreBundle\PublishWorkflow\PublishWorkflowInterface;

/**
 * @PHPCRODM\Document(referenceable=true)
 */
class StaticContent implements RouteAwareInterface, PublishWorkflowInterface
{
    /**
     * to create the document at the specified location. read only for existing documents.
     *
     * @PHPCRODM\Id
     */
    protected $path;

    /**
     * @PHPCRODM\Node
     */
    public $node;

    /**
     * @PHPCRODM\ParentDocument()
     */
    protected $parent;

    /**
     * @PHPCRODM\Nodename()
     */
    protected $name;

    /**
     * @PHPCRODM\String()
     */
    protected $title;

    /**
     * @PHPCRODM\String()
     */
    protected $body;

    /**
     * @PHPCRODM\String(multivalue=true)
     */
    protected $tags = array();

    /**
     * This will usually be a ContainerBlock but can be any block that will be
     * rendered in the additionalInfoBlock area.
     *
     * @var \Sonata\BlockBundle\Model\BlockInterface
     * @PHPCRODM\Child()
     */
    public $additionalInfoBlock;

    /**
     * @var \Doctrine\Common\Collections\ArrayCollection
     * @PHPCRODM\Referrers(filter="routeContent")
     */
    protected $routes;


    public function __construct()
    {
        $this->routes = new ArrayCollection();
    }

    /**
     * Set repository path of this navigation item for creation
     */
    public function setPath($path)
    {
      $this->path = $path;
    }

    public function getPath()
    {
      return $this->path;
    }

    public function setParent($parent)
    {
        $this->parent = $parent;
    }

    public function getParent()
    {
        return $this->parent;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function setTitle($title)
    {
        $this->title = $title;
    }

    public function getBody()
    {
        return $this->body;
    }

    public function setBody($body)
    {
        $this->body = $body;
    }

    public function getTags()
    {
        return $this->tags;
    }

    public function setTags($tags)
    {
        $this->tags = $tags;
    }

    /**
     * Get the publish start date
     */
    public function getPublishStartDate()
    {
        return $this->publishStartDate;
    }

    public function setPublishStartDate(\DateTime $publishStartDate = null)
    {
        $this->publishStartDate = $publishStartDate;
    }

    /**
     * Get the publish end date
     */
    public function getPublishEndDate()
    {
        return $this->publishEndDate;
    }

    public function setPublishEndDate(\DateTime $publishEndDate = null)
    {
        $this->publishEndDate = $publishEndDate;
    }


    /**
     * @param \Symfony\Cmf\Bundle\RoutingExtraBundle\Document\Route $route
     */
    public function addRoute($route)
    {
        $this->routes->add($route);
    }

    /**
     * @param \Symfony\Cmf\Bundle\RoutingExtraBundle\Document\Route $route
     */
    public function removeRoute($route)
    {
        $this->routes->removeElement($route);
    }

    /**
     * @return \Symfony\Component\Routing\Route[] Route instances that point to this content
     */
    public function getRoutes()
    {
        return $this->routes;
    }

    public function __toString()
    {
        return (string) $this->name;
    }
}
