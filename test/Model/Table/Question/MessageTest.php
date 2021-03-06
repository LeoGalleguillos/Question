<?php
namespace LeoGalleguillos\QuestionTest\Model\Table\Question;

use Generator;
use MonthlyBasis\Memcached\Model\Service as MemcachedService;
use LeoGalleguillos\Question\Model\Table as QuestionTable;
use MonthlyBasis\LaminasTest\TableTestCase;
use Laminas\Db\Adapter\Adapter;
use PHPUnit\Framework\TestCase;

class MessageTest extends TableTestCase
{
    protected function setUp(): void
    {
        $this->questionTable = new QuestionTable\Question(
            $this->getAdapter(),
            new MemcachedService\Memcached()
        );
        $this->questionMessageTable = new QuestionTable\Question\Message(
            $this->getAdapter(),
            $this->questionTable
        );

        $this->setForeignKeyChecks(0);
        $this->dropAndCreateTable('question');
        $this->setForeignKeyChecks(1);
    }

    public function testSelectWhereMessageRegularExpression()
    {
        $result = $this->questionMessageTable->selectWhereMessageRegularExpression(
            'oba',
            1,
            1
        );
        $results = iterator_to_array($result);
        $this->assertEmpty($results);

        $this->questionTable->insert(
            1,
            'subject',
            'foobarbaz',
            '1.2.3.4',
            'name',
            '1.2.3.4'
        );
        $this->questionTable->insert(
            1,
            'subject',
            '&lt;b&gt;',
            '1.2.3.4',
            'name',
            '1.2.3.4'
        );

        $result = $this->questionMessageTable->selectWhereMessageRegularExpression(
            'oba',
            0,
            10
        );
        $results = iterator_to_array($result);
        $this->assertSame(
            $results[0]['question_id'],
            '1'
        );

        $result = $this->questionMessageTable->selectWhereMessageRegularExpression(
            '&lt;',
            0,
            10
        );
        $results = iterator_to_array($result);
        $this->assertSame(
            $results[0]['question_id'],
            '2'
        );

        $result = $this->questionMessageTable->selectWhereMessageRegularExpression(
            '&gt;',
            0,
            10
        );
        $results = iterator_to_array($result);
        $this->assertSame(
            $results[0]['question_id'],
            '2'
        );

        $result = $this->questionMessageTable->selectWhereMessageRegularExpression(
            'hello',
            0,
            10
        );
        $results = iterator_to_array($result);
        $this->assertEmpty($results);

        $result = $this->questionMessageTable->selectWhereMessageRegularExpression(
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

    public function testUpdateWhereQuestionId()
    {
        $this->questionTable->insert(
            1,
            'subject',
            'foobarbaz',
            '1.2.3.4',
            'name',
            '1.2.3.4'
        );

        $this->assertFalse(
            $this->questionMessageTable->updateWhereQuestionId(
                'foobarbaz',
                1
            )
        );
        $this->assertTrue(
            $this->questionMessageTable->updateWhereQuestionId(
                'foo, bar, baz',
                1
            )
        );
        $this->assertFalse(
            $this->questionMessageTable->updateWhereQuestionId(
                'foobarbaz',
                2
            )
        );
    }
}
