<?php

/*
 * This file is part of the Symfony CMF package.
 *
 * (c) 2011-2017 Symfony CMF
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Cmf\Bundle\ContentBundle\Doctrine\Phpcr;

use Doctrine\ODM\PHPCR\HierarchyInterface;
use PHPCR\NodeInterface;
use Symfony\Cmf\Bundle\ContentBundle\Model\StaticContent as ModelStaticContent;

/**
 * PHPCR specific static content.
 */
class StaticContent extends ModelStaticContent implements HierarchyInterface
{
    /**
     * PHPCR parent document.
     *
     * @var object
     */
    protected $parent;

    /**
     * PHPCR document name.
     *
     * @var string
     */
    protected $name;

    /**
     * PHPCR node.
     *
     * @var NodeInterface
     */
    protected $node;

    /**
     * {@inheritdoc}
     */
    public function setParentDocument($parent)
    {
        $this->parent = $parent;
    }

    /**
     * {@inheritdoc}
     */
    public function getParentDocument()
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

    /**
     * Get the underlying PHPCR node of this document.
     *
     * @return NodeInterface
     */
    public function getNode()
    {
        return $this->node;
    }
}
