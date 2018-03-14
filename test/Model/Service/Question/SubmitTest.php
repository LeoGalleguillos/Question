<?php
namespace LeoGalleguillos\QuestionTest\Model\Service\Question;

use LeoGalleguillos\Flash\Model\Service as FlashService;
use LeoGalleguillos\Question\Model\Entity as QuestionEntity;
use LeoGalleguillos\Question\Model\Factory as QuestionFactory;
use LeoGalleguillos\Question\Model\Service as QuestionService;
use LeoGalleguillos\Question\Model\Table as QuestionTable;
use PHPUnit\Framework\TestCase;

class SubmitTest extends TestCase
{
    protected function setUp()
    {
        $this->flashServiceMock = $this->createMock(
            FlashService\Flash::class
        );
        $this->questionFactoryMock = $this->createMock(
            QuestionFactory\Question::class
        );
        $this->questionTableMock = $this->createMock(
            QuestionTable\Question::class
        );
        $this->submitQuestionService = new QuestionService\Question\Submit(
            $this->flashServiceMock,
            $this->questionFactoryMock,
            $this->questionTableMock
        );
    }

    public function testInitialize()
    {
        $this->assertInstanceOf(
            QuestionService\Question\Submit::class,
            $this->submitQuestionService
        );
    }
}
