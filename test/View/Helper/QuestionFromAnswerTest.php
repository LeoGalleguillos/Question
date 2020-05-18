<?php
namespace LeoGalleguillos\StringTest\View\Helper;

use LeoGalleguillos\Question\Model\Entity as QuestionEntity;
use LeoGalleguillos\Question\Model\Service as QuestionService;
use LeoGalleguillos\Question\View\Helper as QuestionHelper;
use PHPUnit\Framework\TestCase;

class QuestionFromAnswerTest extends TestCase
{
    protected function setUp(): void
    {
        $this->questionFromAnswerServiceMock = $this->createMock(
            QuestionService\QuestionFromAnswer::class
        );
        $this->questionFromAnswerHelper = new QuestionHelper\QuestionFromAnswer(
            $this->questionFromAnswerServiceMock
        );
    }

    public function testInitialize()
    {
        $this->assertInstanceOf(
            QuestionHelper\QuestionFromAnswer::class,
            $this->questionFromAnswerHelper
        );
    }

    public function testInvoke()
    {
        $answerEntity = new QuestionEntity\Answer();
        $questionEntity = $this->questionFromAnswerHelper->__invoke(
            $answerEntity
        );
        $this->assertInstanceOf(
            QuestionEntity\Question::class,
            $questionEntity
        );
    }
}
