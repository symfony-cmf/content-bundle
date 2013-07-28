<?php

namespace Symfony\Cmf\Bundle\ContentBundle\Document;


class StaticContentBase
{
    /**
     * to create the document at the specified location. read only for existing documents.
     *
     * Identifier
     */
    protected $path;

    /**
     * Node
     */
    protected $node;

    /**
     * Parent Document
     */
    protected $parent;

    /**
     * Node Name
     */
    protected $name;

    /**
     * Document Title
     */
    protected $title;

    /**
     * Body Text
     */
    protected $body;

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
