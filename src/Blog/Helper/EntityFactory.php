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
 * Interface EntityFactory
 *
 * @package Blog\Helper
 */
interface EntityFactory
{
    /**
     * @param string $class
     * @param array  $data
     *
     * @return Entity
     */
    public function create($class, array $data = []);
}