<?php
namespace LeoGalleguillos\QuestionTest\Model\Table\Question;

use Generator;
use LeoGalleguillos\Memcached\Model\Service as MemcachedService;
use LeoGalleguillos\Question\Model\Table as QuestionTable;
use MonthlyBasis\LaminasTest\TableTestCase;

class SubjectTest extends TableTestCase
{
    protected function setUp(): void
    {
        $this->memcachedServiceMock = $this->createMock(
            MemcachedService\Memcached::class
        );
        $this->questionTable = new QuestionTable\Question(
            $this->getAdapter(),
            $this->memcachedServiceMock
        );
        $this->questionSubjectTable = new QuestionTable\Question\Subject(
            $this->adapter,
            $this->questionTable
        );

        $this->setForeignKeyChecks(0);
        $this->dropAndCreateTable('question');
        $this->setForeignKeyChecks(1);
    }

    public function testSelectSubjectCount()
    {
        $generator = $this->questionSubjectTable->selectSubjectCount(50);
        $this->assertEmpty(iterator_to_array($generator));
    }

    public function testSelectWhereRegExpression()
    {
        $result = $this->questionSubjectTable->selectWhereRegularExpression(
            'oba',
            1,
            1
        );
        $results = iterator_to_array($result);
        $this->assertEmpty($results);

        $this->questionTable->insert(
            1,
            'foobarbaz',
            'message',
            '1.2.3.4',
            'name',
            '1.2.3.4'
        );
        $this->questionTable->insert(
            null,
            '&lt;b&gt;',
            'message',
            '1.2.3.4',
            'name',
            '1.2.3.4'
        );

        $result = $this->questionSubjectTable->selectWhereRegularExpression(
            'oba',
            0,
            10
        );
        $results = iterator_to_array($result);
        $this->assertSame(
            1,
            count($results)
        );
        $this->assertSame(
            $results[0]['question_id'],
            '1'
        );

        $result = $this->questionSubjectTable->selectWhereRegularExpression(
            '&lt;',
            0,
            10
        );
        $results = iterator_to_array($result);
        $this->assertSame(
            $results[0]['question_id'],
            '2'
        );

        $result = $this->questionSubjectTable->selectWhereRegularExpression(
            '&gt;',
            0,
            10
        );
        $results = iterator_to_array($result);
        $this->assertSame(
            $results[0]['question_id'],
            '2'
        );

        $result = $this->questionSubjectTable->selectWhereRegularExpression(
            'hello',
            0,
            10
        );
        $results = iterator_to_array($result);
        $this->assertEmpty($results);

        $result = $this->questionSubjectTable->selectWhereRegularExpression(
            '[A-Za-z0-9]+;',
            0,
            10
        );
        $results = iterator_to_array($result);
        $this->assertSame(
            $results[0]['question_id'],
            '2'
        );
    }
}
