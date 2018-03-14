<?php
namespace LeoGalleguillos\QuestionTest\Model\Service;

use Exception;
use LeoGalleguillos\Question\Model\Entity as QuestionEntity;
use LeoGalleguillos\Question\Model\Factory as QuestionFactory;
use LeoGalleguillos\Question\Model\Service as QuestionService;
use LeoGalleguillos\Question\Model\Table as QuestionTable;
use PHPUnit\Framework\TestCase;

class QuestionsTest extends TestCase
{
    protected function setUp()
    {
        $this->questionFactoryMock = $this->createMock(
            QuestionFactory\Question::class
        );
        $this->questionTableMock = $this->createMock(
            QuestionTable\Question::class
        );
        $this->questionsService = new QuestionService\Questions(
            $this->questionFactoryMock,
            $this->questionTableMock
        );
    }

    public function testInitialize()
    {
        $this->assertInstanceOf(
            QuestionService\Questions::class,
            $this->questionsService
        );
    }
}
