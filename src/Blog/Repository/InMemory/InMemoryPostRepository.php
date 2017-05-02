<?php
/**
 * Created by PhpStorm.
 * User: christian
 * Date: 5/2/17
 * Time: 2:28 PM
 */

namespace Blog\Repository\InMemory;


use Blog\Post;
use Blog\Repository\PostRepository;
use Blog\User;

/**
 * Class InMemoryPostRepository
 *
 * @package Blog\Repository\InMemory
 */
class InMemoryPostRepository extends InMemoryEntityRepository implements PostRepository
{

    /**
     * @param User $user
     *
     * @return mixed
     */
    public function getByUser(User $user)
    {
        return $this->getBy(function (Post $post) use ($user) {
            return $post->getUser()->getId() === $user->getId();
        });
    }
}