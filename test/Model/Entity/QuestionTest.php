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
        $userId = 123;
        $this->questionEntity->setUserId($userId);
        $this->assertSame(
            $userId,
            $this->questionEntity->getUserId()
        );

        $createdDateTime = new DateTime();
        $this->questionEntity->setCreatedDateTime($createdDateTime);
        $this->assertSame(
            $createdDateTime,
            $this->questionEntity->getCreatedDateTime()
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
    }
}
