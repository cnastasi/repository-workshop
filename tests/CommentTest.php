<?php
use Blog\Comment;
use PHPUnit\Framework\Assert;

/**
 * Created by PhpStorm.
 * User: christian
 * Date: 3/8/17
 * Time: 5:59 PM
 */
class CommentTest extends BlogTest
{

    /**
     * @test
     */
    public function shouldAddComment()
    {
        $userId1 = $this->createUser('John Smith');
        $userId2 = $this->createUser('Jack Black');
        $postId  = $this->createPost('Just a title', 'Just a content', $userId1);

        $content = 'This is a comment';

        $blog = new Comment();

        $blog->addComment($content, $postId, $userId2);

        $this->assertCommentsEqualsTo(
            [
                [
                    'id'      => '1',
                    'content' => $content,
                    'post_id' => $postId,
                    'user_id' => $userId2
                ]
            ]
        );
    }

    /**
     * @test
     */
    public function shouldListComments()
    {
        $userId1 = $this->createUser('John Doe');
        $userId2 = $this->createUser('Jack Black');
        $userId3 = $this->createUser('Bob Dylan');
        $postId = $this->createPost('Just a title', 'Just a content', $userId1);

        $expectedComments = [
            ['id' => '1', 'content' => 'Just a comment 1', 'user_id' => $userId2, 'post_id' => $postId],
            ['id' => '2', 'content' => 'Just a comment 2', 'user_id' => $userId2, 'post_id' => $postId],
            ['id' => '3', 'content' => 'Just a comment 3', 'user_id' => $userId3, 'post_id' => $postId],
        ];

        $blog = new Comment();

        foreach ($expectedComments as $comment) {
            $blog->addComment($comment['content'], $comment['post_id'], $comment['user_id']);
        }

        $actualComments = $blog->getComments($postId);

        $this->removeDates($actualComments);

        Assert::assertEquals($expectedComments, $actualComments);
    }

    /**
     * @test
     *
     * @expectedException \Blog\Exceptions\EmptyContentException
     */
    public function shouldRaiseEmptyContentException()
    {
        $blog = new Comment();
        $blog->addComment('', null, 0);
    }

    /**
     * @test
     *
     * @expectedException \Blog\Exceptions\NotFoundException
     */
    public function shouldRaiseUserNotFoundException()
    {
        $userId = $this->createUser('John Smith');
        $postId = $this->createPost('Just a title', 'Just a content', 1);

        $blog = new Comment();
        $blog->addComment('Just a comment', $postId, $userId + 1);
    }

    /**
     * @test
     *
     * @expectedException \Blog\Exceptions\NotFoundException
     */
    public function shouldRaisePostNotFoundException()
    {
        $userId = $this->createUser('John Smith');

        $blog = new Comment();
        $blog->addComment('Just a comment', null, $userId);
    }


    private function assertCommentsEqualsTo(array $expectedComments)
    {
        $resultset      = $this->pdo->query('SELECT * FROM comments', PDO::FETCH_ASSOC);
        $actualComments = $resultset->fetchAll();

        Assert::assertEquals($expectedComments, $actualComments);
    }
}