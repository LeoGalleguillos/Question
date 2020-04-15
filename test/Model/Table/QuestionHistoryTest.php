<?php
namespace LeoGalleguillos\QuestionTest\Model\Table;

use Generator;
use Laminas\Db\Adapter\Adapter;
use Laminas\Db\Adapter\Driver\Pdo\Result;
use LeoGalleguillos\Question\Model\Table as QuestionTable;
use LeoGalleguillos\Test\TableTestCase;
use TypeError;

class QuestionHistoryTest extends TableTestCase
{
    /**
     * @var string
     */
    protected $sqlPath;

    protected function setUp()
    {
        $this->questionTable = new QuestionTable\Question(
            $this->getAdapter()
        );
        $this->questionHistoryTable = new QuestionTable\QuestionHistory(
            $this->getAdapter()
        );

        $this->setForeignKeyChecks(0);
        $this->dropAndCreateTables(['question', 'question_history']);
        $this->setForeignKeyChecks(1);
    }

    public function test_getSelect()
    {
        $sql = $this->questionHistoryTable->getSelect()
            . 'FROM `question_history` LIMIT 1;';
        $result = $this->getAdapter()->query($sql)->execute();
        $this->assertInstanceOf(
            Result::class,
            $result
        );
    }

    public function testInsertSelectFromQuestion()
    {
        $questionHistoryId = $this->questionHistoryTable->insertSelectFromQuestion(
            'reason',
            123
        );
        $this->assertSame(
            $questionHistoryId,
            0
        );
    }

    public function test_selectDistinctQuestionId_multipleRows_multipleResults()
    {
        $this->questionTable->insert(
            null,
            'subject',
            'message',
            'created name',
            '1.2.3.4'
        );
        $this->questionTable->insert(
            null,
            'subject 2',
            'message 2',
            'created name 2',
            '5.6.7.8'
        );
        $this->questionHistoryTable->insertSelectFromQuestion(
            'modified reason',
            1
        );
        $this->questionHistoryTable->insertSelectFromQuestion(
            'another modified reason',
            2
        );
        $this->questionHistoryTable->insertSelectFromQuestion(
            'yet another modified reason',
            2
        );
        $result = $this->questionHistoryTable->selectDistinctQuestionId();
        $this->assertCount(
            2,
            $result
        );
        $this->assertSame(
            [
                ['question_id' => '1'],
                ['question_id' => '2'],
            ],
            iterator_to_array($result)
        );
    }

    public function test_selectWhereQuestionIdOrderByCreatedAsc()
    {
        $this->questionTable->insert(
            12345,
            'this is the subject',
            'this is the message',
            'this is the name',
            '1.2.3.4'
        );
        $this->questionHistoryTable->insertSelectFromQuestion(
            'this is the reason',
            1
        );
        $this->questionHistoryTable->insertSelectFromQuestion(
            'this is another reason',
            1
        );
        $result = $this->questionHistoryTable
            ->selectWhereQuestionIdOrderByCreatedAsc(
                1
            );
        $this->assertSame(
            'this is the reason',
            $result->current()['modified_reason']
        );
        $result->next();
        $this->assertSame(
            'this is another reason',
            $result->current()['modified_reason']
        );
    }

    public function test_selectWhereQuestionIdOrderByCreatedDesc()
    {
        $this->questionTable->insert(
            12345,
            'this is the subject',
            'this is the message',
            'this is the name',
            '1.2.3.4'
        );
        $this->questionHistoryTable->insertSelectFromQuestion(
            'this is the reason',
            1
        );
        $this->questionHistoryTable->insertSelectFromQuestion(
            'this is another reason',
            1
        );
        $result = $this->questionHistoryTable
            ->selectWhereQuestionIdOrderByCreatedDesc(
                1
            );
        $this->assertSame(
            'this is another reason',
            $result->current()['modified_reason']
        );
        $result->next();
        $this->assertSame(
            'this is the reason',
            $result->current()['modified_reason']
        );
    }

    public function test_updateSetModifiedReasonWhereQuestionHistoryId_multipleRows_1AffectedRow()
    {
        $this->questionTable->insert(
            12345,
            'this is the subject',
            'this is the message',
            'this is the name',
            '1.2.3.4'
        );
        $this->questionHistoryTable->insertSelectFromQuestion(
            'this is the first reason',
            1
        );
        $this->questionHistoryTable->insertSelectFromQuestion(
            'this is the second reason',
            1
        );

        $result = $this->questionHistoryTable
            ->updateSetModifiedReasonWhereQuestionHistoryId(
                'a modified reason',
                2
            );
        $this->assertSame(
            1,
            $result->getAffectedRows()
        );

        $result = $this->questionHistoryTable
            ->selectWhereQuestionIdOrderByCreatedDesc(
                1
            );
        $this->assertSame(
            'a modified reason',
            $result->current()['modified_reason']
        );
        $result->next();
        $this->assertSame(
            'this is the first reason',
            $result->current()['modified_reason']
        );

        $result = $this->questionHistoryTable
            ->updateSetModifiedReasonWhereQuestionHistoryId(
                null,
                1
            );
        $this->assertSame(
            1,
            $result->getAffectedRows()
        );
        $result = $this->questionHistoryTable
            ->selectWhereQuestionIdOrderByCreatedDesc(
                1
            );
        $this->assertNull(
            iterator_to_array($result)[1]['modified_reason']
        );
    }
}
