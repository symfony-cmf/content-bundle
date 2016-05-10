<?php

namespace Symfony\Cmf\Bundle\ContentBundle\Doctrine\Phpcr;

use Doctrine\ODM\PHPCR\DocumentManager;
use Symfony\Cmf\Bundle\ContentBundle\Model\ManagerInterface;
use Symfony\Cmf\Bundle\ContentBundle\Model\ModelManagerException;

/**
 * @author Maximilian Berghoff <Maximilian.Berghoff@mayflower.de>
 */
class ModelManager implements ManagerInterface
{
    /**
     * @var DocumentManager
     */
    private $documentManager;

    /**
     * ModelManager constructor.
     *
     * @param DocumentManager $documentManager
     */
    public function __construct(DocumentManager $documentManager)
    {
        $this->documentManager = $documentManager;
    }

    /**
     * {@inheritdoc}
     *
     * @throws ModelManagerException if the document manager throws any exception
     */
    public function create($object)
    {
        try {
            $this->documentManager->persist($object);
            $this->documentManager->flush();
        } catch (\Exception $e) {
            throw new ModelManagerException('', 0, $e);
        }
    }

    /**
     * {@inheritdoc}
     *
     * @throws ModelManagerException if the document manager throws any exception
     */
    public function update($object)
    {
        try {
            $this->documentManager->persist($object);
            $this->documentManager->flush();
        } catch (\Exception $e) {
            throw new ModelManagerException('', 0, $e);
        }
    }

    /**
     * {@inheritdoc}
     *
     * @throws ModelManagerException if the document manager throws any exception
     */
    public function delete($object)
    {
        try {
            $this->documentManager->remove($object);
            $this->documentManager->flush();
        } catch (\Exception $e) {
            throw new ModelManagerException('', 0, $e);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function findBy($class, array $criteria = array())
    {
        return $this->documentManager->getRepository($class)->findBy($criteria);
    }
    /**
     * {@inheritdoc}
     */
    public function findOneBy($class, array $criteria = array())
    {
        return $this->documentManager->getRepository($class)->findOneBy($criteria);
    }

    /**
     * Find one object from the given class repository.
     *
     * {@inheritdoc}
     */
    public function find($class, $id)
    {
        if (!isset($id)) {
            return;
        }
        if (null === $class) {
            return $this->documentManager->find(null, $id);
        }
        return $this->documentManager->getRepository($class)->find($id);
    }
}
