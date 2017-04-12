<?php
/**
 * Created by PhpStorm.
 * User: christian
 * Date: 4/11/17
 * Time: 9:08 PM
 */
namespace Blog;


/**
 * Class CommentModel
 *
 * @package Blog\Model
 */
interface Comment extends Entity
{
    /**
     * @return string
     */
    public function getContent() : string;

    /**
     * @return User
     */
    public function getUser() : User;

    /**
     * @return Post
     */
    public function getPost() : Post;
}