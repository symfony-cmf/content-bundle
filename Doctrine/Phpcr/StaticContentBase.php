<?php

/*
 * This file is part of the Symfony CMF package.
 *
 * (c) 2011-2014 Symfony CMF
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Cmf\Bundle\ContentBundle\Doctrine\Phpcr;

use Doctrine\ODM\PHPCR\HierarchyInterface;
use PHPCR\NodeInterface;
use Symfony\Cmf\Bundle\ContentBundle\Model\StaticContentBase as ModelStaticContentBase;

class StaticContentBase extends ModelStaticContentBase implements HierarchyInterface
{
    /**
     * PHPCR parent document
     *
     * @var string
     */
    protected $parent;

    /**
     * PHPCR document name
     *
     * @var string
     */
    protected $name;

    /**
     * PHPCR node
     *
     * @var NodeInterface
     */
    protected $node;

    /**
     * @deprecated Use setParentDocument instead.
     */
    public function setParent($parent)
    {
        $this->setParentDocument($parent);
    }

    /**
     * @deprecated Use getParentDocument instead.
     */
    public function getParent()
    {
        return $this->getParentDocument();
    }

    /**
     * {@inheritDoc}
     */
    public function setParentDocument($parent)
    {
        $this->parent = $parent;
    }

    /**
     * {@inheritDoc}
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
     * Get the underlying PHPCR node of this document
     *
     * @return NodeInterface
     */
    public function getNode()
    {
        return $this->node;
    }
}
