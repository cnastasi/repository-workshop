<?php
/**
 * Created by PhpStorm.
 * User: christian
 * Date: 3/8/17
 * Time: 1:23 PM
 */

namespace Blog;

include_once(__DIR__ . '/../../config.php');

use Blog\Exceptions\EmptyContentException;
use Blog\Exceptions\EmptyTitleException;
use Blog\Exceptions\NotFoundException;
use PDO;

/**
 * Class Blog
 *
 * @package Blog
 */
class Blog
{
    /**
     * @param $title
     * @param $content
     * @param $userId
     *
     * @return int
     *
     * @throws EmptyContentException
     * @throws EmptyTitleException
     * @throws NotFoundException
     */
    public function createPost($title, $content, $userId)
    {
        // Checking if title is not empty
        if (empty($title)) {
            throw new EmptyTitleException();
        }

        // Checking if content is not empty
        if (empty($content)) {
            throw new EmptyContentException();
        }

        // Checking if user exists
        $pdo = $this->getPdo();

        $stmt = $pdo->prepare('SELECT * FROM users WHERE id = ?');
        $stmt->execute([$userId]);

        if ($stmt->rowCount() !== 1) {
            throw new NotFoundException();
        }

        $stmt = $pdo->prepare("INSERT INTO posts (title, content, user_id) VALUES (?, ?, ?)");
        $stmt->execute([$title, $content, $userId]);

        return $pdo->lastInsertId();
    }


    /**
     * Returns all the user's posts
     *
     * @param $userId
     *
     * @return array | null
     * @throws NotFoundException
     */
    public function getPosts($userId)
    {
        // Checking if user exists
        $pdo = $this->getPdo();

        $stmt = $pdo->prepare('SELECT * FROM posts WHERE user_id = ?');

        $stmt->execute([$userId]);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Add a comment
     *
     * @param $content
     * @param $postId
     * @param $userId
     *
     * @throws EmptyContentException
     * @throws NotFoundException
     */
    public function addComment($content, $postId, $userId)
    {
        // Checking if content is not empty
        if (empty($content)) {
            throw new EmptyContentException();
        }

        // Checking if user exists
        $pdo = $this->getPdo();

        $stmt = $pdo->prepare('SELECT * FROM users WHERE id = ?');
        $stmt->execute([$userId]);

        if ($stmt->rowCount() !== 1) {
            throw new NotFoundException();
        }

        $stmt = $pdo->prepare('SELECT * FROM posts WHERE id = ?');
        $stmt->execute([$postId]);

        if ($stmt->rowCount() !== 1) {
            throw new NotFoundException();
        }

        $stmt = $pdo->prepare("INSERT INTO comments (content, post_id, user_id) VALUES (?, ?, ?)");
        $stmt->execute([$content, $postId,  $userId]);
    }

    /**
     * Returns all the post's comments
     *
     * @param $postId
     *
     * @return array
     */
    public function getComments($postId)
    {
        $pdo = $this->getPdo();

        $stmt = $pdo->prepare('SELECT * FROM comments WHERE post_id = ?');
        $stmt->execute([$postId]);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * @return PDO
     */
    private function getPdo()
    {
        $connectionString = sprintf('mysql:host=%s;dbname=%s', DB_HOST, DB_NAME);

        return new PDO($connectionString, DB_USER, DB_PASS);
    }
}