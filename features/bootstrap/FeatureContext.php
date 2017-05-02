<?php

use Behat\Behat\Context\Context;
use Behat\Behat\Hook\Scope\AfterScenarioScope;
use Behat\Behat\Hook\Scope\BeforeScenarioScope;
use Behat\Gherkin\Node\TableNode;
use Blog\Blog;
use PHPUnit\Framework\Assert;

define('TEST', 'test');

require_once 'config.php';

/**
 * Defines application features from the specific context.
 */
class FeatureContext implements Context
{
    /** @var array */
    protected $user;

    /** @var int */
    protected $currentUserId;

    /** @var array */
    protected $posts;

    /** @var array */
    protected $comments;

    /** @var PDO */
    private $pdo;

    /**
     * FeatureContext constructor.
     */
    public function __construct()
    {
        $this->pdo = $this->getPdo();
    }

    /**
     * @BeforeScenario
     */
    public function cleanDB(BeforeScenarioScope $scope)
    {
        $this->pdo->query('TRUNCATE comments');
        $this->pdo->query('TRUNCATE posts');
        $this->pdo->query('TRUNCATE users');
    }

    /**
     * @BeforeScenario
     */
    public function cleanProperties()
    {
        $this->comments      = null;
        $this->posts         = null;
        $this->currentUserId = null;
        $this->user          = null;
    }

    /**
     * @return PDO
     */
    private function getPdo()
    {
        $connectionString = sprintf('mysql:host=%s;dbname=%s', DB_HOST, DB_NAME);

        return new PDO($connectionString, DB_USER, DB_PASS);
    }

    /**
     * @Given /^an user:$/
     */
    public function anUser(TableNode $table)
    {
        $data = $table->getRowsHash();

        $this->createAnUser($data);
    }

    /**
     * @When /^the user (\d+) publish a post:$/
     */
    public function theUserPublishAPost($userId, TableNode $table)
    {
        $post = $table->getRowsHash();

        $blog = new Blog();

        $blog->createPost($post['title'], $post['content'], $userId);

        $post['id']      = 1;
        $post['user_id'] = $userId;

        $this->posts = [
            $post
        ];
    }

    /**
     * @Given /^those users:$/
     */
    public function thoseUsers(TableNode $table)
    {
        $rows = $table->getHash();

        foreach ($rows as $row) {
            $this->createAnUser($row);
        }
    }

    /**
     * @Given /^those posts:$/
     */
    public function thosePosts(TableNode $table)
    {
        $rows = $table->getHash();

        foreach ($rows as $row) {
            $this->createAPost($row);
        }
    }

    /**
     * @Given /^those comments:$/
     */
    public function thoseComments(TableNode $table)
    {
        $rows = $table->getHash();

        foreach ($rows as $row) {
            $this->createAComment($row);
        }
    }

    /**
     * @param string    $tableName
     * @param TableNode $table
     */
    private function iSee($tableName, $expectedData)
    {
        $records = $this->pdo->query("SELECT * FROM {$tableName}");

        $data = $records->fetchAll(PDO::FETCH_ASSOC);

        $this->clearDate($data);

        Assert::assertEquals($expectedData, $data);
    }

    private function createAnUser($data)
    {
        $statement = $this->pdo->prepare('INSERT INTO users (id, name) VALUES (:id, :name)');
        $statement->execute($data);
    }

    private function createAPost($data)
    {
        $query = 'INSERT INTO posts (id, title, content, user_id) ' .
                 'VALUES (:id, :title, :content, :author)';

        $statement = $this->pdo->prepare($query);
        $statement->execute($data);
    }

    private function createAComment($data)
    {
        $query = 'INSERT INTO comments (id, content, post_id, user_id) ' .
                 'VALUES (:id, :content, :post, :author)';

        $statement = $this->pdo->prepare($query);
        $statement->execute($data);
    }

    /**
     * @When /^the user (\d+) comment the post (\d+):$/
     */
    public function theUserCommentThePost1($userId, $postId, TableNode $table)
    {
        $comment = $table->getRow(0);

        $blog = new Blog();

        $blog->addComment($comment[0], $postId, $userId);

        $this->comments = [
            [
                'id'      => 1,
                'content' => $comment[0],
                'post_id' => $postId,
                'user_id' => $userId
            ]
        ];
    }

    /**
     * @Then /^I see those comments:$/
     */
    public function iSeeThoseComments(TableNode $table)
    {
        $expectedComments = $table->getHash();

        Assert::assertEquals($expectedComments, $this->comments);
    }

    /**
     * @Then /^I see the posts for user (\d+):$/
     */
    public function iSeeThePostsForUser($userId, TableNode $table)
    {
        $blog = new Blog();

        $posts = $blog->getPosts($userId);

        $this->clearDate($posts);

        $expectedData = $table->getHash();

        Assert::assertEquals($expectedData, $posts);
    }

    private function clearDate(array &$data)
    {
        foreach ($data as &$row) {
            unset($row['date']);
        }
    }

    /**
     * @Given /^I'm the user (\d+)$/
     */
    public function iMTheUser($userId)
    {
        $this->currentUserId = $userId;
    }

    /**
     * @When /^I request all my posts$/
     */
    public function iRequestAllMyPosts()
    {
        $blog = new Blog();

        $posts = $blog->getPosts($this->currentUserId);

        $this->clearDate($posts);

        $this->posts = $posts;
    }

    /**
     * @Then /^I see those posts:$/
     */
    public function iSeeThosePosts(TableNode $table)
    {
        $expectedPosts = $table->getHash();

        Assert::assertEquals($expectedPosts, $this->posts);
    }

    /**
     * @When /^I request all the comments of the post (\d+)$/
     */
    public function iRequestAllTheCommentsOfThePost($postId)
    {
        $blog = new Blog();

        $comments = $blog->getComments($postId);

        $this->clearDate($comments);

        $this->comments = $comments;
    }

    /**
     * @Then /^the comment is stored$/
     */
    public function theCommentIsStored()
    {
        $this->iSee('comments', $this->comments);
    }

    /**
     * @Then /^the post is stored$/
     */
    public function thePostIsStored()
    {
        $this->iSee('posts', $this->posts);
    }
}