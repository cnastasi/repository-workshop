<?php
/**
 * Created by PhpStorm.
 * User: christian
 * Date: 4/11/17
 * Time: 9:04 PM
 */

namespace Blog\Model;

use Blog\Comment;
use Blog\Post;
use Blog\User;

/**
 * Class CommentModel
 *
 * @package Blog\Model
 */
class CommentModel implements Comment
{
    /** @var int */
    private $id;

    /** @var string */
    private $content;

    /** @var User */
    private $user;

    /** @var Post */
    private $post;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getContent(): string
    {
        return $this->content;
    }

    /**
     * @return User
     */
    public function getUser(): User
    {
        return $this->user;
    }

    /**
     * @return Post
     */
    public function getPost(): Post
    {
        return $this->post;
    }
}