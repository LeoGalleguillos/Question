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

        $created = new DateTime();
        $this->answerEntity->setCreated($created);
        $this->assertSame(
            $created,
            $this->answerEntity->getCreated()
        );
    }
}
