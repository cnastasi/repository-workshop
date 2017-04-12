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
     * @param Entity $entity
     */
    public function save(Entity $entity);
}