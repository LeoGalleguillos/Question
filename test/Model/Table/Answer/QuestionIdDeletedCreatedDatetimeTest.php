<?php
namespace LeoGalleguillos\QuestionTest\Model\Table\Answer;

use DateTime;
use LeoGalleguillos\Question\Model\Table as QuestionTable;
use LeoGalleguillos\Test\TableTestCase;

class QuestionIdDeletedCreatedDatetimeTest extends TableTestCase
{
    protected function setUp(): void
    {
        $this->answerTable = new QuestionTable\Answer(
            $this->getAdapter()
        );
        $this->questionIdDeletedCreatedDatetimeTable = new QuestionTable\Answer\QuestionIdDeletedCreatedDatetime(
            $this->getAdapter()
        );

        $this->dropTable('answer');
        $this->createTable('answer');
    }

    public function testSelectCountWhereQuestionIdCreatedDatetimeGreaterThanAndMessageEquals()
    {
        $dateTime = DateTime::createFromFormat(
            'U',
            time() - 3600 // One hour ago
        );

        $count = $this->questionIdDeletedCreatedDatetimeTable
            ->selectCountWhereQuestionIdCreatedDatetimeGreaterThanAndMessageEquals(
            12345,
            $dateTime,
            'message'
        );
        $this->assertSame(
            0,
            $count
        );

        $this->answerTable->insert(
            12345,
            null,
            'message',
            '1.2.3.4',
            'name',
            '1.2.3.4'
        );
        $this->answerTable->insert(
            12345,
            null,
            'message',
            '1.2.3.4',
            'name2',
            '1.2.3.4'
        );

        $count = $this->questionIdDeletedCreatedDatetimeTable
            ->selectCountWhereQuestionIdCreatedDatetimeGreaterThanAndMessageEquals(
            12345,
            $dateTime,
            'message'
        );
        $this->assertSame(
            2,
            $count
        );

        $this->answerTable->insert(
            12345,
            null,
            'message3',
            '1.2.3.4',
            'name3',
            '1.2.3.4'
        );

        $count = $this->questionIdDeletedCreatedDatetimeTable
            ->selectCountWhereQuestionIdCreatedDatetimeGreaterThanAndMessageEquals(
            12345,
            $dateTime,
            'message'
        );
        $this->assertSame(
            2,
            $count
        );
    }
}
