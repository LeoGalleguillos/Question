<?php
namespace LeoGalleguillos\QuestionTest\Model\Entity;

use DateTime;
use LeoGalleguillos\Question\Model\Entity as QuestionEntity;
use PHPUnit\Framework\TestCase;

class AnswerTest extends TestCase
{
    protected function setUp()
    {
        $this->answerEntity = new QuestionEntity\Answer();
    }

    public function testInitialize()
    {
        $this->assertInstanceOf(
            QuestionEntity\Answer::class,
            $this->answerEntity
        );
    }

    public function testGettersAndSetters()
    {
        $userId = 123;
        $this->answerEntity->setUserId($userId);
        $this->assertSame(
            $userId,
            $this->answerEntity->getUserId()
        );

        $createdDateTime = new DateTime();
        $this->answerEntity->setCreatedDateTime($createdDateTime);
        $this->assertSame(
            $createdDateTime,
            $this->answerEntity->getCreatedDateTime()
        );

        $deletedUserId = 123;
        $this->assertSame(
            $this->answerEntity,
            $this->answerEntity->setDeletedUserId($deletedUserId)
        );
        $this->assertSame(
            $deletedUserId,
            $this->answerEntity->getDeletedUserId()
        );

        $deletedReason = 'this is the reason';
        $this->assertSame(
            $this->answerEntity,
            $this->answerEntity->setDeletedReason($deletedReason)
        );
        $this->assertSame(
            $deletedReason,
            $this->answerEntity->getDeletedReason()
        );
    }
}
