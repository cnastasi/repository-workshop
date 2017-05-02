<?php
/**
 * Created by PhpStorm.
 * User: christian
 * Date: 5/2/17
 * Time: 2:16 PM
 */

namespace Blog\Repository\InMemory;


use Blog\Entity;
use Blog\Repository\EntityRepository;

/**
 * Class InMemoryEntityRepository
 *
 * @package Blog\Repository\InMemory
 */
class InMemoryEntityRepository implements EntityRepository
{
    private $items = [];

    /**
     * @param Entity $entity
     */
    public function save(Entity $entity)
    {
        $this->items[$entity->getId()] = $entity;
    }

    /**
     * @param $id
     *
     * @return Entity
     *
     * @throws \Exception
     */
    public function get($id)
    {
        if (!array_key_exists($id, $this->items)) {
            throw new \Exception("Item not found with {$id} id");
        }

        return $this->items[$id];
    }

    /**
     * @return Entity[]
     */
    public function getAll()
    {
        return array_values($this->items);
    }

    /**
     * @param callable $filter
     *
     * @return array
     */
    protected function getBy(callable $filter)
    {
        $items = $this->getAll();

        return array_filter($items, $filter);
    }
}