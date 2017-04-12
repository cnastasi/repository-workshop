<?php
/**
 * Created by PhpStorm.
 * User: christian
 * Date: 4/11/17
 * Time: 8:43 PM
 */

namespace Blog\Model;

use Blog\Post;
use Blog\User;

/**
 * Class PostModel
 *
 * @package Blog\Model
 */
class PostModel implements Post
{
    /** @var int */
    private $id;

    /** @var string */
    private $title;

    /** @var string */
    private $content;

    /** @var User */
    private $user;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @return string
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * @return User
     */
    public function getUser()
    {
        return $this->user;
    }
}