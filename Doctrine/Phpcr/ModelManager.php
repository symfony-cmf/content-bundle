<?php

namespace Symfony\Cmf\Bundle\ContentBundle\Doctrine\Phpcr;

use Symfony\Cmf\Bundle\ContentBundle\Model\ManagerInterface;

/**
 * @author Maximilian Berghoff <Maximilian.Berghoff@mayflower.de>
 */
class ModelManager implements ManagerInterface
{

    /**
     * @param mixed $object
     *
     * @return mixed
     */
    public function create($object)
    {
        // TODO: Implement create() method.
    }

    /**
     * @param mixed $object
     *
     * @return mixed
     */
    public function update($object)
    {
        // TODO: Implement update() method.
    }

    /**
     * @param object $object
     */
    public function delete($object)
    {
        // TODO: Implement delete() method.
    }

    /**
     * @param string $class
     * @param array $criteria
     *
     * @return array all objects matching the criteria
     */
    public function findBy($class, array $criteria = array())
    {
        // TODO: Implement findBy() method.
    }

    /**
     * @param string $class
     * @param array $criteria
     *
     * @return object an object matching the criteria or null if none match
     */
    public function findOneBy($class, array $criteria = array())
    {
        // TODO: Implement findOneBy() method.
    }

    /**
     * @param string $class
     * @param mixed $id
     *
     * @return object the object with id or null if not found
     */
    public function find($class, $id)
    {
        // TODO: Implement find() method.
    }
}
