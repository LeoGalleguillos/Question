<?php
namespace LeoGalleguillos\QuestionTest\Model\Service\Question;

use LeoGalleguillos\Question\Model\Entity as QuestionEntity;
use LeoGalleguillos\Question\Model\Service as QuestionService;
use LeoGalleguillos\Question\Model\Table as QuestionTable;
use PHPUnit\Framework\TestCase;

class IncrementViewsTest extends TestCase
{
    protected function setUp(): void
    {
        $this->questionTableMock = $this->createMock(
            QuestionTable\Question::class
        );
        $this->incrementViewsService = new QuestionService\Question\IncrementViews(
            $this->questionTableMock
        );
    }

    public function testInitialize()
    {
        $this->assertInstanceOf(
            QuestionService\Question\IncrementViews::class,
            $this->incrementViewsService
        );
    }

    public function testIncrementViews()
    {
        $questionEntity = new QuestionEntity\Question();
        $questionEntity->setQuestionId(123);

        $this->questionTableMock
             ->method('updateViewsWhereQuestionId')
             ->willReturn(true);

        $this->assertTrue(
            $this->incrementViewsService->incrementViews($questionEntity)
        );
    }
}
