<?php
/**
 * Created by PhpStorm.
 * User: christian
 * Date: 4/11/17
 * Time: 9:35 PM
 */

namespace Blog\Helper;

use Blog\Entity;

/**
 * Interface EntitySerializer
 *
 * @package Blog\Helper
 */
interface EntitySerializer
{
    /**
     * @param Entity $entity
     *
     * @return array
     */
    public function serialize(Entity $entity);
}