<?php
namespace LeoGalleguillos\AnswerTest\Model\Table;

use LeoGalleguillos\Question\Model\Table as QuestionTable;
use LeoGalleguillos\Test\TableTestCase;

class AnswerTest extends TableTestCase
{
    protected function setUp()
    {
        $this->dropAndCreateTable('answer');
        $this->answerTable = new QuestionTable\Answer(
            $this->getAdapter()
        );
        $this->answerIdTable = new QuestionTable\Answer\AnswerId(
            $this->getAdapter(),
            $this->answerTable
        );
    }

    public function testInsertAndSelectCount()
    {
        $this->assertSame(
            0,
            $this->answerTable->selectCount()
        );
        $this->answerTable->insert(
            1, 2, 'first message', null, '1.2.3.4'
        );
        $this->answerTable->insert(
            3, null, 'second message', 'name', '1.2.3.4'
        );
        $this->answerTable->insert(
            5, 6, 'third message', 'another name', '5.6.7.8'
        );
        $this->assertSame(
            3,
            $this->answerTable->selectCount()
        );
    }

    public function testInsertDeleted()
    {
        $answerId = $this->answerTable->insertDeleted(
            12345,
            null,
            'message',
            'name',
            '1.2.3.4',
            '0',
            'foul language'
        );
        $this->assertSame(
            1,
            $answerId
        );

        $array = $this->answerTable->selectWhereAnswerId(1);
        $this->assertSame(
            '0',
            $array['deleted_user_id']
        );
        $this->assertSame(
            'foul language',
            $array['deleted_reason']
        );
    }

    public function testSelectWhereAnswerId()
    {
        $this->answerTable->insert(
            1, 2, 'first message', null, '1.2.3.4'
        );
        $this->answerTable->insert(
            3, null, 'second message', 'name', '1.2.3.4'
        );
        $this->answerTable->insert(
            5, 6, 'third message', 'another name', '5.6.7.8'
        );

        $this->assertSame(
            'first message',
            $this->answerTable->selectWhereAnswerId(1)['message']
        );
        $this->assertSame(
            'third message',
            $this->answerTable->selectWhereAnswerId(3)['message']
        );
    }

    public function testSelectWhereQuestionId()
    {
        $generator = $this->answerTable->selectWhereQuestionId(12345);
        $this->assertEmpty(
            iterator_to_array($generator)
        );
    }

    public function test_updateWhereAnswerId()
    {
        $this->answerTable->insert(
            1, 2, 'first message', null, '1.2.3.4'
        );
        $result = $this->answerTable->updateWhereAnswerId(
            'new name',
            'modified message',
            10,
            'modified reason',
            1
        );
        $this->assertSame(
            1,
            $result->getAffectedRows()
        );
        $result = $this->answerIdTable->selectWhereAnswerId(1);
        $this->assertSame(
            'new name',
            $result->current()['created_name']
        );
        $this->assertSame(
            'modified message',
            $result->current()['message']
        );
        $this->assertSame(
            'modified reason',
            $result->current()['modified_reason']
        );

        $result = $this->answerTable->updateWhereAnswerId(
            null,
            'modified message',
            10,
            'modified reason',
            1
        );
        $this->assertSame(
            1,
            $result->getAffectedRows()
        );
        $result = $this->answerIdTable->selectWhereAnswerId(1);
        $this->assertNull(
            $result->current()['created_name']
        );
    }
}
