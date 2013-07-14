<?php

namespace Symfony\Cmf\Bundle\ContentBundle\Document;

use Doctrine\ODM\PHPCR\Mapping\Annotations as PHPCRODM;
use Doctrine\Common\Collections\ArrayCollection;

use Symfony\Cmf\Bundle\CoreBundle\PublishWorkflow\PublishableWriteInterface;
use Symfony\Cmf\Bundle\CoreBundle\PublishWorkflow\PublishTimePeriodWriteInterface;
use Symfony\Cmf\Bundle\MenuBundle\Document\MenuNode;
use Symfony\Cmf\Component\Routing\RouteAwareInterface;

/**
 * @PHPCRODM\Document(referenceable=true)
 */
class StaticContent implements RouteAwareInterface, PublishTimePeriodWriteInterface, PublishableWriteInterface
{
    /**
     * to create the document at the specified location. read only for existing documents.
     *
     * @PHPCRODM\Id
     */
    protected $path;

    /**
     * @var \PHPCR\NodeInterface
     * @PHPCRODM\Node
     */
    protected $node;

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
     * Hashmap for application data associated to this document
     *
     * @PHPCRODM\String(assoc="")
     */
    protected $extras;

    /**
     * This will usually be a ContainerBlock but can be any block that will be
     * rendered in the additionalInfoBlock area.
     *
     * @var \Sonata\BlockBundle\Model\BlockInterface
     * @PHPCRODM\Child(cascade="persist")
     */
    protected $additionalInfoBlock;

    /**
     * @PHPCRODM\Boolean()
     */
    protected $publishable = true;

    /**
     * @PHPCRODM\Date()
     */
    protected $publishStartDate;

    /**
     * @PHPCRODM\Date()
     */
    protected $publishEndDate;

    /**
     * @var \Doctrine\Common\Collections\ArrayCollection
     * @PHPCRODM\Referrers(referringDocument="Symfony\Cmf\Bundle\RoutingBundle\Document\Route", referencedBy="routeContent", cascade="persist")
     */
    protected $routes;

    /**
     * If the menu is built with hard references, then referencedBy would be "strongContent".
     *
     * \Doctrine\Common\Collections\ArrayCollection
     * @PHPCRODM\Referrers(referringDocument="Symfony\Cmf\Bundle\MenuBundle\Document\MenuNode", referencedBy="weakContent", cascade="persist")
     */
    protected $menus;

    public function __construct()
    {
        $this->routes = new ArrayCollection();
        $this->menus = new ArrayCollection();
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

    public function getAdditionalInfoBlock()
    {
        return $this->additionalInfoBlock;
    }

    public function setAdditionalInfoBlock($block)
    {
        $this->additionalInfoBlock = $block;
    }

    /**
     * Set if the content is publishable
     *
     * @param boolean $publishable
     */
    public function setPublishable($publishable)
    {
        return $this->publishable = (bool) $publishable;
    }

    /**
     * Is publishable
     *
     * @return boolean $publishable
     */
    public function isPublishable()
    {
        return $this->publishable;
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
     * Get the application information associated with this document
     *
     * @return array
     */
    public function getExtras()
    {
        return $this->extras;
    }

    /**
     * Get a single application information value
     *
     * @param string      $name
     * @param string|null $default
     *
     * @return string|null the value at $name if set, null otherwise
     */
    public function getExtra($name, $default = null)
    {
        return isset($this->extras[$name]) ? $this->extras[$name] : $default;
    }

    /**
     * Set the application information
     *
     * @param array $extras
     *
     * @return StaticContent - this instance
     */
    public function setExtras(array $extras)
    {
        $this->extras = $extras;

        return $this;
    }

    /**
     * Set a single application information value.
     *
     * @param string $name
     * @param string $value the new value, null removes the entry
     *
     * @return StaticContent - this instance
     */
    public function setExtra($name, $value)
    {
        if (is_null($value)) {
            unset($this->extras[$name]);
        } else {
            $this->extras[$name] = $value;
        }

        return $this;
    }

    /**
     * @param \Symfony\Cmf\Bundle\RoutingBundle\Document\Route $route
     */
    public function addRoute($route)
    {
        $this->routes->add($route);
    }

    /**
     * @param \Symfony\Cmf\Bundle\RoutingBundle\Document\Route $route
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

    /**
     * @param MenuNode $menu
     */
    public function addMenu($menu)
    {
        $this->menus->add($menu);
    }

    /**
     * @param MenuNode $menu
     */
    public function removeMenu($menu)
    {
        $this->menus->removeElement($menu);
    }

    /**
     * @return ArrayCollection of MenuNode that point to this content
     */
    public function getMenus()
    {
        return $this->menus;
    }

    /**
     * Get the underlying PHPCR node of this document
     *
     * @return \PHPCR\NodeInterface
     */
    public function getNode()
    {
        return $this->node;
    }

    public function __toString()
    {
        return (string) $this->name;
    }
}
