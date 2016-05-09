<?php

namespace Symfony\Cmf\Bundle\ContentBundle\Model;

/**
 * A model manager is a bridge between several persistence implementations.
 *
 * @author Maximilian Berghoff <Maximilian.Berghoff@mayflower.de>
 */
interface ManagerInterface
{
    /**
     * @param mixed $object
     *
     * @return mixed
     */
    public function create($object);

    /**
     * @param mixed $object
     *
     * @return mixed
     */
    public function update($object);

    /**
     * @param object $object
     */
    public function delete($object);

    /**
     * @param string $class
     * @param array  $criteria
     *
     * @return array all objects matching the criteria
     */
    public function findBy($class, array $criteria = array());

    /**
     * @param string $class
     * @param array  $criteria
     *
     * @return object an object matching the criteria or null if none match
     */
    public function findOneBy($class, array $criteria = array());

    /**
     * @param string $class
     * @param mixed  $id
     *
     * @return object the object with id or null if not found
     */
    public function find($class, $id);
}
