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

        $created = new DateTime();
        $this->questionEntity->setCreated($created);
        $this->assertSame(
            $created,
            $this->questionEntity->getCreated()
        );
    }
}
