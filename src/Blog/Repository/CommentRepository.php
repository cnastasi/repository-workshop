<?php
/**
 * Created by PhpStorm.
 * User: christian
 * Date: 4/11/17
 * Time: 9:25 PM
 */

namespace Blog\Repository;

use Blog\Comment;
use Blog\Post;


/**
 * Interface CommentRepository
 *
 * @package Blog\Repository
 */
interface CommentRepository extends EntityRepository
{
    /**
     * @param Post $post
     *
     * @return Comment[]
     */
    public function getByPost(Post $post);
}