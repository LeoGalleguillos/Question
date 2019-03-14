<?php
namespace LeoGalleguillos\QuestionTest\Model\Service\Answer;

use LeoGalleguillos\Question\Model\Service as QuestionService;
use LeoGalleguillos\Question\Model\Table as QuestionTable;
use PHPUnit\Framework\TestCase;

class DuplicateTest extends TestCase
{
    protected function setUp()
    {
        $this->questionIdDeletedCreatedDatetimeTableMock = $this->createMock(
            QuestionTable\Answer\QuestionIdDeletedCreatedDatetime::class
        );

        $this->duplicateService = new QuestionService\Answer\Duplicate(
            $this->questionIdDeletedCreatedDatetimeTableMock
        );
    }

    public function testIsDuplicate()
    {
        $this->questionIdDeletedCreatedDatetimeTableMock->method(
            'selectCountWhereQuestionIdCreatedDatetimeGreaterThanAndMessageEquals'
        )->will(
            $this->onConsecutiveCalls(
                0, 1, 2
            )
        );

        $this->assertFalse(
            $this->duplicateService->isDuplicate(
                12345,
                'message'
            )
        );
        $this->assertTrue(
            $this->duplicateService->isDuplicate(
                12345,
                'message'
            )
        );
        $this->assertTrue(
            $this->duplicateService->isDuplicate(
                12345,
                'message'
            )
        );
    }
}
