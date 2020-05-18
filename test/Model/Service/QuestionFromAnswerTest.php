<?php
namespace LeoGalleguillos\QuestionTest\Model\Service\Question;

use LeoGalleguillos\Question\Model\Entity as QuestionEntity;
use LeoGalleguillos\Question\Model\Factory as QuestionFactory;
use LeoGalleguillos\Question\Model\Service as QuestionService;
use PHPUnit\Framework\TestCase;

class QuestionFromAnswerTest extends TestCase
{
    protected function setUp(): void
    {
        $this->questionFactoryMock = $this->createMock(
            QuestionFactory\Question::class
        );
        $this->questionFromAnswerService = new QuestionService\QuestionFromAnswer(
            $this->questionFactoryMock
        );
    }

    public function testInitialize()
    {
        $this->assertInstanceOf(
            QuestionService\QuestionFromAnswer::class,
            $this->questionFromAnswerService
        );
    }

    public function testGetQuestionFromAnswer()
    {
        $answerEntity = new QuestionEntity\Answer();
        $answerEntity->setQuestionId(123);
        $questionEntity = $this->questionFromAnswerService->getQuestionFromAnswer(
            $answerEntity
        );
        $this->assertInstanceOf(
            QuestionEntity\Question::class,
            $questionEntity
        );
    }
}
