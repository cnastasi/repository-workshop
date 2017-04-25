<?php

use Behat\Behat\Hook\Scope\AfterScenarioScope;
use Behat\Behat\Tester\Exception\PendingException;
use Behat\Behat\Context\Context;
use Behat\Gherkin\Node\PyStringNode;
use Behat\Gherkin\Node\TableNode;
use Behat\Testwork\Hook\Scope\BeforeSuiteScope;
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
    protected $post;

    /** @var array */
    protected $user;

    /** @var PDO */
    private $pdo;

    public function __construct()
    {
        $this->pdo = $this->getPdo();
    }

    /**
     * @AfterScenario
     */
    public function cleanDB(AfterScenarioScope $scope)
    {
        $this->pdo->query('TRUNCATE comments');
        $this->pdo->query('TRUNCATE posts');
        $this->pdo->query('TRUNCATE users');
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

    private function createAnUser($data)
    {
        $statement = $this->pdo->prepare('INSERT INTO users (id, name) VALUES (:id, :name)');
        $statement->execute($data);
    }

    /**
     * @When /^the user (\d+) publish a post:$/
     */
    public function theUserPublishAPost($userId, TableNode $table)
    {
        $this->post = $table->getRowsHash();

        $blog = new Blog();

        $blog->createPost($this->post['title'], $this->post['content'], $userId);
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
     * @Then /^I can see the post:$/
     */
    public function iCanSeeThePost(TableNode $table)
    {
        $expectedData = $table->getRowsHash();

        $statement = $this->pdo->prepare('SELECT * FROM posts WHERE id=:id');

        $statement->execute(['id' => $expectedData['id']]);

        $data = $statement->fetch(PDO::FETCH_ASSOC);

        unset($data['date']);

        Assert::assertEquals($expectedData, $data);
    }
}
