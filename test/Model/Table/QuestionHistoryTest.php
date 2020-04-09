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

    public function test_selectDistinctQuestionId_emptyTable_emptyResult()
    {
        $result = $this->questionHistoryTable->selectDistinctQuestionId();
        $this->assertEmpty($result);
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
        $result = $this->questionHistoryTable
            ->selectWhereQuestionIdOrderByCreatedAsc(
                1
            );
        $this->assertEmpty($result);

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
}
