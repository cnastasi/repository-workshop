<?php
/**
 * Created by PhpStorm.
 * User: christian
 * Date: 4/11/17
 * Time: 8:31 PM
 */

namespace Blog;


/**
 * Interface User
 *
 * @package Blog
 */
interface User extends Entity
{
    /**
     * @return string
     */
    public function getName();
}