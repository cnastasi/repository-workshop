<?php
/**
 * Created by PhpStorm.
 * User: christian
 * Date: 4/11/17
 * Time: 9:12 PM
 */

namespace Blog\Repository;


use Blog\Entity;

/**
 * Interface EntityRepository
 *
 * @package Blog\Repository
 */
interface EntityRepository
{
    /**
     * @param $id
     *
     * @return mixed
     */
    public function get($id);

    /**
     * @return mixed
     */
    public function getAll();

    /**
     * @param Entity $entity
     */
    public function save(Entity $entity);
}