<?php
namespace LeoGalleguillos\QuestionTest\Model\Table;

use Generator;
use Laminas\Db\Adapter\Adapter;
use Laminas\Db\Adapter\Driver\Pdo\Result;
use LeoGalleguillos\Question\Model\Table as QuestionTable;
use LeoGalleguillos\Test\TableTestCase;
use TypeError;

class AnswerHistoryTest extends TableTestCase
{
    /**
     * @var string
     */
    protected $sqlPath;

    protected function setUp()
    {
        $this->answerTable = new QuestionTable\Answer(
            $this->getAdapter()
        );
        $this->answerHistoryTable = new QuestionTable\AnswerHistory(
            $this->getAdapter()
        );

        $this->setForeignKeyChecks(0);
        $this->dropAndCreateTables(['answer', 'answer_history']);
        $this->setForeignKeyChecks(1);
    }

    public function test_selectDistinctAnswerId_emptyTable_emptyResult()
    {
        $result = $this->answerHistoryTable->selectDistinctAnswerId();
        $this->assertEmpty($result);
    }

    public function test_selectDistinctQuestionId_multipleRows_multipleResults()
    {
        $this->answerTable->insert(
            1,
            null,
            'message',
            'created name',
            '1.2.3.4'
        );
        $this->answerTable->insert(
            99,
            null,
            'message',
            'created name',
            '1.2.3.4'
        );
        $this->answerTable->insert(
            99,
            null,
            'message',
            'created name',
            '1.2.3.4'
        );
        $this->answerHistoryTable->insertSelectFromAnswer(
            'modified reason',
            1
        );
        $this->answerHistoryTable->insertSelectFromAnswer(
            'another modified reason',
            2
        );
        $this->answerHistoryTable->insertSelectFromAnswer(
            'yet another modified reason',
            2
        );
        $this->answerHistoryTable->insertSelectFromAnswer(
            'yet another modified reason again',
            2
        );
        $result = $this->answerHistoryTable->selectDistinctAnswerId();
        $this->assertCount(
            2,
            $result
        );
        $this->assertSame(
            [
                ['answer_id' => '1'],
                ['answer_id' => '2'],
            ],
            iterator_to_array($result)
        );
    }
}
