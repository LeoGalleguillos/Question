<?php
namespace LeoGalleguillos\QuestionTest\Model\Table\Question;

use MonthlyBasis\Memcached\Model\Service as MemcachedService;
use LeoGalleguillos\Question\Model\Table as QuestionTable;
use MonthlyBasis\LaminasTest\TableTestCase;

class DeletedTest extends TableTestCase
{
    /**
     * @var string
     */
    protected $sqlPath;

    protected function setUp(): void
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

        $this->setForeignKeyChecks(0);
        $this->dropAndCreateTable('question');
        $this->setForeignKeyChecks(1);
    }

    public function testInitialize()
    {
        $this->assertInstanceOf(
            QuestionTable\Question\Deleted::class,
            $this->questionDeletedTable
        );
    }
}
