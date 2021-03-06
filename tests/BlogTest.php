<?php

define('TEST', 'test');

require_once __DIR__ . '/../config.php';

/**
 * Created by PhpStorm.
 * User: christian
 * Date: 3/8/17
 * Time: 5:59 PM
 */
abstract class BlogTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @var PDO
     */
    protected $pdo;

    public function setUp()
    {
        parent::setUp();

        $this->pdo = $this->getPdo();

        $this->cleanDB();

        $this->seedUsers();
    }

    protected function cleanDB()
    {
        $this->pdo->query('TRUNCATE comments');
        $this->pdo->query('TRUNCATE posts');
        $this->pdo->query('TRUNCATE users');
    }

    /**
     * @param $name
     *
     * @return string
     */
    protected function createUser($name)
    {
        $stmt = $this->pdo->prepare('INSERT INTO users (name) VALUES (?)');
        $stmt->execute([$name]);

        return $this->pdo->lastInsertId();
    }

    /**
     * @param $title
     * @param $content
     * @param $userId
     *
     * @return string
     */
    protected function createPost($title, $content, $userId)
    {
        $stmt = $this->pdo->prepare('INSERT INTO posts (title, content, user_id) VALUES (?, ?, ?)');
        $stmt->execute([$title, $content, $userId]);

        return $this->pdo->lastInsertId();
    }

    /**
     * @return PDO
     */
    private function getPdo()
    {
        $connectionString = sprintf('mysql:host=%s;dbname=%s', DB_HOST, DB_NAME);

        return new PDO($connectionString, DB_USER, DB_PASS);
    }


    protected function seedUsers()
    {
        $this->createUser('John Smith');
        $this->createUser('Mario Rossi');

    }

    /**
     * @param array $actualPosts
     */
    protected function removeDates(array &$actualPosts)
    {
        $actualPosts = array_map(
            function ($row) {
                unset($row['date']);

                return $row;
            },
            $actualPosts
        );
    }
}