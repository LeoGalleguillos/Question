<?php
namespace LeoGalleguillos\QuestionTest\Model\Service\Answer\Delete\Queue;

use Exception;
use LeoGalleguillos\Question\Model\Entity as QuestionEntity;
use LeoGalleguillos\Question\Model\Factory as QuestionFactory;
use LeoGalleguillos\Question\Model\Service as QuestionService;
use LeoGalleguillos\Question\Model\Table as QuestionTable;
use LeoGalleguillos\User\Model\Entity as UserEntity;
use PHPUnit\Framework\TestCase;

class AddTest extends TestCase
{
    protected function setUp(): void
    {
        $this->answerDeleteQueueTableMock = $this->createMock(
            QuestionTable\AnswerDeleteQueue::class
        );
        $this->addService = new QuestionService\Answer\Delete\Queue\Add(
            $this->answerDeleteQueueTableMock
        );
    }

    public function testInitialize()
    {
        $this->assertInstanceOf(
            QuestionService\Answer\Delete\Queue\Add::class,
            $this->addService
        );
    }

    public function testDelete()
    {
        $userEntity = new UserEntity\User();
        $userEntity->setUserId(1);

        $answerEntity = new QuestionEntity\Answer();
        $answerEntity->setAnswerId(1);

        $this->assertFalse(
            $this->addService->add(
                $userEntity,
                $answerEntity,
                'reason'
            )
        );
    }
}
