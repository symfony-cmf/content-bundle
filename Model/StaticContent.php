<?php

/*
 * This file is part of the Symfony CMF package.
 *
 * (c) 2011-2015 Symfony CMF
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Cmf\Bundle\ContentBundle\Model;

use Doctrine\Common\Collections\ArrayCollection;
use Knp\Menu\NodeInterface;
use Sonata\BlockBundle\Model\BlockInterface;
use Symfony\Cmf\Bundle\CoreBundle\Translatable\TranslatableInterface;
use Symfony\Cmf\Component\Routing\RouteObjectInterface;
use Symfony\Cmf\Component\Routing\RouteReferrersInterface;
use Symfony\Cmf\Bundle\CoreBundle\PublishWorkflow\PublishTimePeriodInterface;
use Symfony\Cmf\Bundle\CoreBundle\PublishWorkflow\PublishableInterface;
use Symfony\Cmf\Bundle\MenuBundle\Model\MenuNode;
use Symfony\Cmf\Bundle\MenuBundle\Model\MenuNodeReferrersInterface;

/**
 * Standard implementation of StaticContent:.
 *
 * Standard features:
 *
 * - Publish workflow
 * - Translatable
 * - RouteAware
 * - MenuAware
 *
 * Bundle specific:
 *
 * - Tags
 * - Additional Info Block
 */
class StaticContent extends StaticContentBase implements
    MenuNodeReferrersInterface,
    RouteReferrersInterface,
    PublishTimePeriodInterface,
    PublishableInterface,
    TranslatableInterface
{
    /**
     * @var bool whether this content is publishable
     */
    protected $publishable = true;

    /**
     * @var \DateTime|null publication start time
     */
    protected $publishStartDate;

    /**
     * @var \DateTime|null publication end time
     */
    protected $publishEndDate;

    /**
     * @var string
     */
    protected $locale;

    /**
     * @var RouteObjectInterface[]
     */
    protected $routes;

    /**
     * @var MenuNode[]
     */
    protected $menuNodes;

    /**
     * @var string[]
     */
    protected $tags = array();

    /**
     * Hashmap for application data associated to this document. Both keys and
     * values must be strings.
     *
     * @var array
     */
    protected $extras = array();

    /**
     * This will usually be a ContainerBlock but can be any block that will be
     * rendered in the additionalInfoBlock area.
     *
     * @var \Sonata\BlockBundle\Model\BlockInterface
     */
    protected $additionalInfoBlock;

    public function __construct()
    {
        $this->routes = new ArrayCollection();
        $this->menuNodes = new ArrayCollection();
    }

    /**
     * {@inheritdoc}
     */
    public function getLocale()
    {
        return $this->locale;
    }

    /**
     * {@inheritdoc}
     */
    public function setLocale($locale)
    {
        $this->locale = $locale;
    }

    /**
     * Get the tags set on this content.
     *
     * @return string[]
     */
    public function getTags()
    {
        return $this->tags;
    }

    /**
     * Set the tags of this content as an array of strings.
     *
     * @param string[] $tags
     */
    public function setTags($tags)
    {
        $this->tags = $tags;
    }

    /**
     * @return BlockInterface
     */
    public function getAdditionalInfoBlock()
    {
        return $this->additionalInfoBlock;
    }

    /**
     * Set the additional info block for this content. Usually you want this to
     * be a container block in order to be able to add several blocks.
     *
     * @param BlockInterface $block must be persistable through cascade by the
     *                              persistence layer.
     */
    public function setAdditionalInfoBlock($block)
    {
        $this->additionalInfoBlock = $block;
    }

    /**
     * {@inheritdoc}
     */
    public function setPublishable($publishable)
    {
        return $this->publishable = (bool) $publishable;
    }

    /**
     * {@inheritdoc}
     */
    public function isPublishable()
    {
        return $this->publishable;
    }

    /**
     * {@inheritdoc}
     */
    public function getPublishStartDate()
    {
        return $this->publishStartDate;
    }

    /**
     * {@inheritdoc}
     */
    public function setPublishStartDate(\DateTime $publishStartDate = null)
    {
        $this->publishStartDate = $publishStartDate;
    }

    /**
     * {@inheritdoc}
     */
    public function getPublishEndDate()
    {
        return $this->publishEndDate;
    }

    /**
     * {@inheritdoc}
     */
    public function setPublishEndDate(\DateTime $publishEndDate = null)
    {
        $this->publishEndDate = $publishEndDate;
    }

    /**
     * Get the application information associated with this document.
     *
     * @return array
     */
    public function getExtras()
    {
        return $this->extras;
    }

    /**
     * Get a single application information value.
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
     * Set the application information.
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
     * {@inheritdoc}
     */
    public function addRoute($route)
    {
        $this->routes->add($route);
    }

    /**
     * {@inheritdoc}
     */
    public function removeRoute($route)
    {
        $this->routes->removeElement($route);
    }

    /**
     * {@inheritdoc}
     */
    public function getRoutes()
    {
        return $this->routes;
    }

    /**
     * {@inheritdoc}
     */
    public function addMenuNode(NodeInterface $menu)
    {
        $this->menuNodes->add($menu);
    }

    /**
     * {@inheritdoc}
     */
    public function removeMenuNode(NodeInterface $menu)
    {
        $this->menuNodes->removeElement($menu);
    }

    /**
     * {@inheritdoc}
     */
    public function getMenuNodes()
    {
        return $this->menuNodes;
    }
}
