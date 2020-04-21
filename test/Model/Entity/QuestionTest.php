<?php
namespace LeoGalleguillos\QuestionTest\Model\Entity;

use DateTime;
use LeoGalleguillos\Question\Model\Entity as QuestionEntity;
use PHPUnit\Framework\TestCase;

class QuestionTest extends TestCase
{
    protected function setUp()
    {
        $this->questionEntity = new QuestionEntity\Question();
    }

    public function testInitialize()
    {
        $this->assertInstanceOf(
            QuestionEntity\Question::class,
            $this->questionEntity
        );
    }

    public function testGettersAndSetters()
    {
        $createdDateTime = new DateTime();
        $this->questionEntity->setCreatedDateTime($createdDateTime);
        $this->assertSame(
            $createdDateTime,
            $this->questionEntity->getCreatedDateTime()
        );

        $createdUserId = 12345;
        $this->assertSame(
            $this->questionEntity,
            $this->questionEntity->setCreatedUserId($createdUserId)
        );
        $this->assertSame(
            $createdUserId,
            $this->questionEntity->getCreatedUserId()
        );

        $deletedDateTime = new DateTime();
        $this->assertSame(
            $this->questionEntity,
            $this->questionEntity->setDeletedDateTime($deletedDateTime)
        );
        $this->assertSame(
            $deletedDateTime,
            $this->questionEntity->getDeletedDateTime()
        );

        $deletedUserId = 123;
        $this->assertSame(
            $this->questionEntity,
            $this->questionEntity->setDeletedUserId($deletedUserId)
        );
        $this->assertSame(
            $deletedUserId,
            $this->questionEntity->getDeletedUserId()
        );

        $deletedReason = 'this is the reason';
        $this->assertSame(
            $this->questionEntity,
            $this->questionEntity->setDeletedReason($deletedReason)
        );
        $this->assertSame(
            $deletedReason,
            $this->questionEntity->getDeletedReason()
        );

        $userId = 123;
        $this->assertSame(
            $this->questionEntity,
            $this->questionEntity->setUserId($userId)
        );
        $this->assertSame(
            $userId,
            $this->questionEntity->getUserId()
        );
    }
}
