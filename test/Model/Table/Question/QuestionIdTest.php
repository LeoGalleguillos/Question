<?php
namespace LeoGalleguillos\QuestionTest\Model\Table\Question;

use LeoGalleguillos\Question\Model\Table as QuestionTable;
use LeoGalleguillos\Test\TableTestCase;

class QuestionIdTest extends TableTestCase
{
    protected function setUp()
    {
        $this->questionTable = new QuestionTable\Question(
            $this->getAdapter()
        );
        $this->questionIdTable = new QuestionTable\Question\QuestionId(
            $this->getAdapter()
        );

        $this->dropAndCreateTable('question');
    }

    public function testUpdateSetDeletedColumnsWhereQuestionId()
    {
        $rowsAffected = $this->questionIdTable->updateSetDeletedColumnsWhereQuestionId(
            3,
            'deleted reason',
            1
        );
        $this->assertSame(
            0,
            $rowsAffected
        );

        $this->questionTable->insert(
            null,
            'name',
            'subject',
            'message',
            'ip',
            'name',
            'ip'
        );

        $rowsAffected = $this->questionIdTable->updateSetDeletedColumnsWhereQuestionId(
            3,
            'deleted reason',
            1
        );
        $this->assertSame(
            1,
            $rowsAffected
        );
        $array = $this->questionTable->selectWhereQuestionId(1);
        $this->assertNotNull(
            $array['deleted_datetime']
        );
        $this->assertSame(
            '3',
            $array['deleted_user_id']
        );
        $this->assertSame(
            'deleted reason',
            $array['deleted_reason']
        );
    }

    public function testUpdateIncrementViewsBrowserWhereQuestionId()
    {
        $rowsAffected = $this->questionIdTable->updateIncrementViewsBrowserWhereQuestionId(
            1
        );
        $this->assertSame(
            0,
            $rowsAffected
        );

        $this->questionTable->insert(
            null,
            'name',
            'subject',
            'message',
            'ip',
            'name',
            'ip'
        );

        $rowsAffected = $this->questionIdTable->updateIncrementViewsBrowserWhereQuestionId(
            1
        );
        $this->assertSame(
            1,
            $rowsAffected
        );
        $array = $this->questionTable->selectWhereQuestionId(1);
        $this->assertSame(
            '1',
            $array['views_browser']
        );
    }

    public function test_updateSetModifiedReasonWhereQuestionId_emptyTable_0AffectedRows()
    {
        $result = $this->questionIdTable
            ->updateSetModifiedReasonWhereQuestionId(
                'modified reason',
                12345
            );
        $this->assertSame(
            0,
            $result->getAffectedRows()
        );
    }

    public function test_updateSetModifiedReasonWhereQuestionId_multipleRows_1AffectedRow()
    {
        $this->questionTable->insert(
            null,
            'name',
            'subject',
            'message',
            'ip'
        );
        $this->questionTable->insert(
            null,
            'name 2',
            'subject 2',
            'message 2',
            'ip 2'
        );

        $result = $this->questionIdTable
            ->updateSetModifiedReasonWhereQuestionId(
                'a modified reason',
                2
            );
        $this->assertSame(
            1,
            $result->getAffectedRows()
        );
        $array = $this->questionTable->selectWhereQuestionId(2);
        $this->assertSame(
            'a modified reason',
            $array['modified_reason']
        );
    }

    public function testUpdateSetViewsBrowserWhereQuestionId()
    {
        $rowsAffected = $this->questionIdTable->updateSetViewsBrowserWhereQuestionId(
            777,
            1
        );
        $this->assertSame(
            0,
            $rowsAffected
        );

        $this->questionTable->insert(
            null,
            'name',
            'subject',
            'message',
            'ip',
            'name',
            'ip'
        );

        $rowsAffected = $this->questionIdTable->updateSetViewsBrowserWhereQuestionId(
            777,
            1
        );
        $this->assertSame(
            1,
            $rowsAffected
        );

        $array = $this->questionTable->selectWhereQuestionId(1);
        $this->assertSame(
            '777',
            $array['views_browser']
        );
    }
}
