<?php
/**
 * Created by PhpStorm.
 * User: christian
 * Date: 4/11/17
 * Time: 8:19 PM
 */

namespace Blog;


/**
 * Interface Post
 *
 * @package Blog
 */
interface Post extends Entity
{
    /**
     * @return string
     */
    public function getTitle();

    /**
     * @return string
     */
    public function getContent();

    /**
     * @return User
     */
    public function getUser();
}