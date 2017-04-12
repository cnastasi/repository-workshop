<?php
/**
 * Created by PhpStorm.
 * User: christian
 * Date: 4/11/17
 * Time: 9:24 PM
 */

namespace Blog\Repository;

use Blog\User;


/**
 * Interface PostRepository
 *
 * @package Blog\Repository
 */
interface PostRepository extends EntityRepository
{
    /**
     * @param User $user
     *
     * @return mixed
     */
    public function getByUser(User $user);
}