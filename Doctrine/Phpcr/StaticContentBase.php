<?php

/*
 * This file is part of the Symfony CMF package.
 *
 * (c) 2011-2015 Symfony CMF
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
     * PHPCR parent document.
     *
     * @var string
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
     * @deprecated Use setParentDocument instead.
     */
    public function setParent($parent)
    {
        @trigger_error(__METHOD__.' is deprecated since 1.1 and will be removed in 2.0. Use setParentDocument() instead.');

        $this->setParentDocument($parent);
    }

    /**
     * @deprecated Use getParentDocument instead.
     */
    public function getParent()
    {
        @trigger_error(__METHOD__.' is deprecated since 1.1 and will be removed in 2.0. Use getParentDocument() instead.');

        return $this->getParentDocument();
    }

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
