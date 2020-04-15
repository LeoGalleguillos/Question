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

    public function test_getSelect()
    {
        $sql = $this->answerHistoryTable->getSelect()
            . 'FROM `answer_history` LIMIT 1;';
        $result = $this->getAdapter()->query($sql)->execute();
        $this->assertInstanceOf(
            Result::class,
            $result
        );
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

    public function test_selectWhereAnswerIdOrderByCreatedAsc()
    {
        $this->answerTable->insert(
            2,
            123,
            'message',
            'created name',
            '1.2.3.4'
        );

        $this->answerHistoryTable->insertSelectFromAnswer(
            'this is the reason',
            1
        );
        $this->answerHistoryTable->insertSelectFromAnswer(
            'this is another reason',
            1
        );
        $result = $this->answerHistoryTable
            ->selectWhereAnswerIdOrderByCreatedAsc(
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

    public function test_selectWhereAnswerIdOrderByCreatedDesc()
    {
        $this->answerTable->insert(
            2,
            123,
            'message',
            'created name',
            '1.2.3.4'
        );

        $this->answerHistoryTable->insertSelectFromAnswer(
            'this is the reason',
            1
        );
        $this->answerHistoryTable->insertSelectFromAnswer(
            'this is another reason',
            1
        );
        $result = $this->answerHistoryTable
            ->selectWhereAnswerIdOrderByCreatedDesc(
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

    public function test_updateSetModifiedReasonWhereAnswerHistoryId_multipleRows_1AffectedRow()
    {
        $this->answerTable->insert(
            99,
            null,
            'message',
            'created name',
            '1.2.3.4'
        );
        $this->answerHistoryTable->insertSelectFromAnswer(
            'this is the first reason',
            1
        );
        $this->answerHistoryTable->insertSelectFromAnswer(
            'this is the second reason',
            1
        );

        $result = $this->answerHistoryTable
            ->updateSetModifiedReasonWhereAnswerHistoryId(
                'a modified reason',
                2
            );
        $this->assertSame(
            1,
            $result->getAffectedRows()
        );

        $result = $this->answerHistoryTable
            ->selectWhereAnswerIdOrderByCreatedDesc(
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

        $result = $this->answerHistoryTable
            ->updateSetModifiedReasonWhereAnswerHistoryId(
                null,
                1
            );
        $this->assertSame(
            1,
            $result->getAffectedRows()
        );
        $result = $this->answerHistoryTable
            ->selectWhereAnswerIdOrderByCreatedDesc(
                1
            );
        $this->assertNull(
            iterator_to_array($result)[1]['modified_reason']
        );
    }
}
