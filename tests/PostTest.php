<?php

use Blog\Blog;
use PHPUnit\Framework\Assert;


/**
 * Created by PhpStorm.
 * User: christian
 * Date: 3/8/17
 * Time: 5:58 PM
 */
class PostTest extends BlogTest
{
    /**
     * @test
     */
    public function shouldCreatePost()
    {
        $userId  = $this->createUser('John Doe');
        $title   = 'Just a title';
        $content = 'Lorem ipsum etc etc';

        $blog = new Blog();
        $blog->createPost($title, $content, $userId);

        $this->assertPostsEqualsTo(
            [
                [
                    'id'      => 1,
                    'title'   => $title,
                    'content' => $content,
                    'user_id' => $userId
                ]
            ]
        );
    }

    /**
     * @test
     */
    public function shouldListPosts()
    {
        $userId = $this->createUser('Joh Doe');

        $expectedPosts = [
            ['id' => '1', 'title' => 'Just a title 1', 'content' => 'Just a content 1', 'user_id' => $userId],
            ['id' => '2', 'title' => 'Just a title 2', 'content' => 'Just a content 2', 'user_id' => $userId],
            ['id' => '3', 'title' => 'Just a title 3', 'content' => 'Just a content 3', 'user_id' => $userId],
        ];

        $blog = new Blog();

        foreach ($expectedPosts as $post) {
            $blog->createPost($post['title'], $post['content'], $post['user_id']);
        }

        $actualPosts = $blog->getPosts($userId);

        $this->removeDates($actualPosts);

        Assert::assertEquals($expectedPosts, $actualPosts);
    }

    /**
     * @test
     *
     * @expectedException \Blog\Exceptions\EmptyTitleException
     */
    public function shouldRaiseEmptyTitleException()
    {
        $blog = new Blog();
        $blog->createPost('', null, 0);
    }

    /**
     * @test
     *
     * @expectedException \Blog\Exceptions\EmptyContentException
     */
    public function shouldRaiseEmptyContentException()
    {
        $blog = new Blog();
        $blog->createPost('Just a title', null, 0);
    }

    /**
     * @test
     *
     * @expectedException \Blog\Exceptions\NotFoundException
     */
    public function shouldRaiseUserNotFoundException()
    {
        $blog = new Blog();
        $blog->createPost('Just a title', 'A content', 0);
    }

    private function assertPostsEqualsTo(array $expectedResult)
    {
        $result = $this->pdo->query("SELECT id, title, content, user_id FROM posts", PDO::FETCH_ASSOC);

        \PHPUnit\Framework\Assert::assertEquals($expectedResult, $result->fetchAll());
    }
}