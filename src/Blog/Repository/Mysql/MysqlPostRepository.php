<?php
/**
 * Created by PhpStorm.
 * User: christian
 * Date: 4/12/17
 * Time: 2:34 PM
 */

namespace Blog\Repository\Mysql;


use Blog\Post;
use Blog\Repository\PostRepository;
use Blog\User;

/**
 * Class MysqlPostRepository
 *
 * @package Blog\Repository\Mysql
 */
class MysqlPostRepository extends MysqlRepository  implements PostRepository
{

    /**
     * @return string
     */
    protected function getTable()
    {
        return 'posts';
    }

    /**
     * @return string
     */
    protected function getEntity()
    {
        return Post::class;
    }

    /**
     * @param User $user
     *
     * @return mixed
     */
    public function getByUser(User $user)
    {
        return $this->getBy('user_id = ?', [$user->getId()]);
    }
}