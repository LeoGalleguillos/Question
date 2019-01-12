<?php
namespace LeoGalleguillos\QuestionTest\Model\Table\Question;

use LeoGalleguillos\Memcached\Model\Service as MemcachedService;
use LeoGalleguillos\Question\Model\Table as QuestionTable;
use LeoGalleguillos\Test\TableTestCase;

class DeletedTest extends TableTestCase
{
    /**
     * @var string
     */
    protected $sqlPath;

    protected function setUp()
    {
        $this->memcachedServiceMock = $this->createMock(
            MemcachedService\Memcached::class
        );

        $this->questionTable = new QuestionTable\Question(
            $this->getAdapter(),
            $this->memcachedServiceMock
        );
        $this->questionDeletedTable = new QuestionTable\Question\Deleted(
            $this->getAdapter(),
            $this->memcachedServiceMock,
            $this->questionTable
        );

        $this->dropTable('question');
        $this->createTable('question');
    }

    public function testInitialize()
    {
        $this->assertInstanceOf(
            QuestionTable\Question\Deleted::class,
            $this->questionDeletedTable
        );
    }

    public function testInsertAndSelectCount()
    {
        $this->assertFalse(
            $this->questionDeletedTable->updateSetToUtcTimestampWhereQuestionId(1)
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

        $this->assertTrue(
            $this->questionDeletedTable->updateSetToUtcTimestampWhereQuestionId(1)
        );
    }
}
