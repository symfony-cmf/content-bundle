<?php

namespace Symfony\Cmf\Bundle\ContentBundle\Doctrine\Phpcr;

use PHPCR\NodeInterface;

use Symfony\Cmf\Bundle\ContentBundle\Model\StaticContent as ModelStaticContent;

/**
 * PHPCR specific static content.
 */
class StaticContent extends ModelStaticContent
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

    /**
     * Get the underlying PHPCR node of this document
     *
     * @return NodeInterface
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
