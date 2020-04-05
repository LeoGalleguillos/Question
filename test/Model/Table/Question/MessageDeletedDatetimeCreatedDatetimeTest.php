<?php
namespace LeoGalleguillos\QuestionTest\Model\Table\Question;

use LeoGalleguillos\Question\Model\Table as QuestionTable;
use LeoGalleguillos\Test\TableTestCase;

class MessageDeletedDatetimeCreatedDatetimeTest extends TableTestCase
{
    protected function setUp()
    {
        $this->questionTable = new QuestionTable\Question(
            $this->getAdapter()
        );
        $this->messageDeletedDatetimeCreatedDatetimeTable = new QuestionTable\Question\MessageDeletedDatetimeCreatedDatetime(
            $this->getAdapter(),
            $this->questionTable
        );

        $this->dropAndCreateTable('question');
    }

    public function test_selectWhereMessageAndDeletedDatetimeIsNullOrderByCreatedDatetimeDescLimit1_emptyTable_emptyResult()
    {
        $result = $this->messageDeletedDatetimeCreatedDatetimeTable
            ->selectWhereMessageAndDeletedDatetimeIsNullOrderByCreatedDatetimeDescLimit1(
                'this is the message'
            );
        $this->assertEmpty($result);
    }

    public function test_selectWhereMessageAndDeletedDatetimeIsNullOrderByCreatedDatetimeDescLimit1_multipleRows_oneResult()
    {
        $this->questionTable->insert(
            null,
            'this is the subject',
            'this is the message',
            'this is the name',
            '1.2.3.4'
        );
        $this->questionTable->insert(
            null,
            'this is another subject',
            'this is the message',
            'this is another name',
            '5.6.7.8'
        );

        $result = $this->messageDeletedDatetimeCreatedDatetimeTable
            ->selectWhereMessageAndDeletedDatetimeIsNullOrderByCreatedDatetimeDescLimit1(
                'this is the message'
            );
        $this->assertSame(
            [
                '2',
                'this is another subject',
                'this is the message',
                'this is another name',
                '5.6.7.8',
            ],
            [
                $result->current()['question_id'],
                $result->current()['subject'],
                $result->current()['message'],
                $result->current()['created_name'],
                $result->current()['created_ip'],
            ]
        );
    }

    public function test_selectWhereMessageAndDeletedDatetimeIsNullOrderByCreatedDatetimeDescLimit1_deletedRow_oneResult()
    {
        $this->questionTable->insert(
            null,
            'this is the subject',
            'this is the message',
            'this is the name',
            '1.2.3.4'
        );
        $this->questionTable->insertDeleted(
            0,
            'this is another subject',
            'this is the message',
            'this is another name',
            '5.6.7.8',
            '99',
            'deleted reason'
        );

        $result = $this->messageDeletedDatetimeCreatedDatetimeTable
            ->selectWhereMessageAndDeletedDatetimeIsNullOrderByCreatedDatetimeDescLimit1(
                'this is the message'
            );
        $this->assertSame(
            [
                '1',
                'this is the subject',
                'this is the message',
                'this is the name',
                '1.2.3.4',
            ],
            [
                $result->current()['question_id'],
                $result->current()['subject'],
                $result->current()['message'],
                $result->current()['created_name'],
                $result->current()['created_ip'],
            ]
        );
    }
}
