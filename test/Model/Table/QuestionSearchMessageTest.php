<?php
namespace LeoGalleguillos\QuestionTest\Model\Table;

use LeoGalleguillos\Memcached\Model\Service as MemcachedService;
use LeoGalleguillos\Question\Model\Table as QuestionTable;
use LeoGalleguillos\Test\TableTestCase;

class QuestionSearchMessageTest extends TableTestCase
{
    protected function setUp(): void
    {
        $this->memcachedServiceMock = $this->createMock(
            MemcachedService\Memcached::class
        );
        $this->questionSearchMessageTable = new QuestionTable\QuestionSearchMessage(
            $this->memcachedServiceMock,
            $this->getAdapter()
        );

        $this->setForeignKeyChecks(0);
        $this->dropAndCreateTable('question_search_message');
        $this->setForeignKeyChecks(1);
    }

    public function test_selectQuestionIdWhereMatchAgainstOrderByViewsDescScoreDesc()
    {
        $result = $this->questionSearchMessageTable
            ->selectQuestionIdWhereMatchAgainstOrderByViewsDescScoreDesc(
                'the search query',
                0,
                100
            );
        $this->assertEmpty(
            iterator_to_array($result)
        );
    }
}
