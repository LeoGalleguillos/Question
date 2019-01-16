<?php
namespace LeoGalleguillos\QuestionTest\Model\Table\Question;

use LeoGalleguillos\Question\Model\Table as QuestionTable;
use LeoGalleguillos\Memcached\Model\Service as MemcachedService;
use LeoGalleguillos\Test\TableTestCase;

class QuestionIdTest extends TableTestCase
{
    protected function setUp()
    {
        $this->memcachedServiceMock = $this->createMock(
            MemcachedService\Memcached::class
        );
        $this->questionTable = new QuestionTable\Question(
            $this->getAdapter(),
            $this->memcachedServiceMock
        );
        $this->questionIdTable = new QuestionTable\Question\QuestionId(
            $this->getAdapter()
        );

        $this->dropTable('question');
        $this->createTable('question');
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
