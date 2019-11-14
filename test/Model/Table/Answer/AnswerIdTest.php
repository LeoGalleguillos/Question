<?php
namespace LeoGalleguillos\QuestionTest\Model\Table\Answer;

use LeoGalleguillos\Question\Model\Table as QuestionTable;
use LeoGalleguillos\Memcached\Model\Service as MemcachedService;
use LeoGalleguillos\Test\TableTestCase;

class AnswerIdTest extends TableTestCase
{
    protected function setUp()
    {
        $this->memcachedServiceMock = $this->createMock(
            MemcachedService\Memcached::class
        );
        $this->answerTable = new QuestionTable\Answer(
            $this->getAdapter(),
            $this->memcachedServiceMock
        );
        $this->answerIdTable = new QuestionTable\Answer\AnswerId(
            $this->getAdapter()
        );

        $this->dropTable('answer');
        $this->createTable('answer');
    }

    public function testUpdateSetDeletedColumnsWhereAnswerId()
    {
        $rowsAffected = $this->answerIdTable->updateSetDeletedColumnsWhereAnswerId(
            2,
            'deleted reason',
            1
        );
        $this->assertSame(
            0,
            $rowsAffected
        );

        $this->answerTable->insert(
            12345,
            null,
            'name',
            'subject',
            'ip',
            'name',
            'ip'
        );

        $rowsAffected = $this->answerIdTable->updateSetDeletedColumnsWhereAnswerId(
            4,
            'deleted reason',
            1
        );
        $this->assertSame(
            1,
            $rowsAffected
        );
        $array = $this->answerTable->selectWhereAnswerId(1);
        $this->assertNotNull(
            $array['deleted_datetime']
        );
        $this->assertSame(
            '4',
            $array['deleted_user_id']
        );
        $this->assertSame(
            'deleted reason',
            $array['deleted_reason']
        );
    }
}
