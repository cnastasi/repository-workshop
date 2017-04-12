<?php
/**
 * Created by PhpStorm.
 * User: christian
 * Date: 4/12/17
 * Time: 2:41 PM
 */

namespace Blog\Repository\Mysql;

use Blog\Comment;
use Blog\Post;
use Blog\Repository\CommentRepository;


/**
 * Class MysqlCommentRepository
 *
 * @package Blog\Repository\Mysql
 */
class MysqlCommentRepository extends MysqlRepository  implements CommentRepository
{

    /**
     * @return string
     */
    protected function getTable()
    {
        return 'comments';
    }

    /**
     * @return string
     */
    protected function getEntity()
    {
        return Comment::class;
    }

    /**
     * @param Post $post
     *
     * @return array
     */
    public function getByPost(Post $post)
    {
        return $this->getBy('post_id = ?', [$post->getId()]);
    }
}