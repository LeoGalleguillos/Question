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
            1
        );
        $this->questionHistoryTable->insertSelectFromQuestion(
            2
        );
        $this->questionHistoryTable->insertSelectFromQuestion(
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
            1
        );
        $this->questionHistoryTable->insertSelectFromQuestion(
            1
        );
        $result = $this->questionHistoryTable
            ->selectWhereQuestionIdOrderByCreatedAsc(
                1
            );
        $this->assertSame(
            '1',
            $result->current()['question_history_id']
        );
        $result->next();
        $this->assertSame(
            '2',
            $result->current()['question_history_id']
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
            1
        );
        $this->questionHistoryTable->insertSelectFromQuestion(
            1
        );
        $result = $this->questionHistoryTable
            ->selectWhereQuestionIdOrderByCreatedDesc(
                1
            );
        $this->assertSame(
            '2',
            $result->current()['question_history_id']
        );
        $result->next();
        $this->assertSame(
            '1',
            $result->current()['question_history_id']
        );
    }

    public function test_updateSetCreatedWhereQuestionHistoryId_multipleRows()
    {
        $this->questionTable->insert(
            12345,
            'this is the subject',
            'this is the message',
            'this is the name',
            '1.2.3.4'
        );
        $this->questionHistoryTable->insertSelectFromQuestion(
            1
        );
        $this->questionHistoryTable->insertSelectFromQuestion(
            1
        );

        $result = $this->questionHistoryTable
            ->updateSetCreatedWhereQuestionHistoryId(
                '2010-04-15 15:07:35',
                3
            );
        $this->assertSame(
            0,
            $result->getAffectedRows()
        );

        $result = $this->questionHistoryTable
            ->updateSetCreatedWhereQuestionHistoryId(
                '2010-04-15 15:07:35',
                2
            );
        $this->assertSame(
            1,
            $result->getAffectedRows()
        );

        $result = $this->questionHistoryTable
            ->selectWhereQuestionIdOrderByCreatedAsc(
                1
            );
        $this->assertSame(
            '2010-04-15 15:07:35',
            $result->current()['created']
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
            1
        );
        $this->questionHistoryTable->insertSelectFromQuestion(
            1
        );

        $result = $this->questionHistoryTable
            ->updateSetModifiedReasonWhereQuestionHistoryId(
                'a modified reason for question_history_id 2',
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
            'a modified reason for question_history_id 2',
            $result->current()['modified_reason']
        );
        $result->next();
        $this->assertNull(
            $result->current()['modified_reason']
        );

        $result = $this->questionHistoryTable
            ->updateSetModifiedReasonWhereQuestionHistoryId(
                'a modified reason for question_history_id 1',
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
        $this->assertSame(
            'a modified reason for question_history_id 1',
            iterator_to_array($result)[1]['modified_reason']
        );
    }
}
