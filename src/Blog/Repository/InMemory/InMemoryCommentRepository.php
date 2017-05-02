<?php
/**
 * Created by PhpStorm.
 * User: christian
 * Date: 5/2/17
 * Time: 2:21 PM
 */

namespace Blog\Repository\InMemory;


use Blog\Comment;
use Blog\Post;
use Blog\Repository\CommentRepository;

/**
 * Class InMemoryCommentRepository
 *
 * @package Blog\Repository\InMemory
 */
class InMemoryCommentRepository extends InMemoryEntityRepository implements CommentRepository
{

    /**
     * @param Post $post
     *
     * @return Comment[]
     */
    public function getByPost(Post $post)
    {
        return $this->getBy(function (Comment $comment) use ($post) {
            return $comment->getPost()->getId() === $post->getId();
        });
    }
}