<?php
namespace LeoGalleguillos\QuestionTest\Model\Table\Question;

use ArrayObject;
use Exception;
use Generator;
use LeoGalleguillos\Question\Model\Table as QuestionTable;
use LeoGalleguillos\QuestionTest\TableTestCase;
use Zend\Db\Adapter\Adapter;
use PHPUnit\Framework\TestCase;

class MessageTest extends TableTestCase
{
    /**
     * @var string
     */
    protected $sqlPath;

    protected function setUp()
    {
        $this->sqlPath = $_SERVER['PWD'] . '/sql/leogalle_test/question/';

        $configArray   = require($_SERVER['PWD'] . '/config/autoload/local.php');
        $configArray   = $configArray['db']['adapters']['leogalle_test'];
        $this->adapter = new Adapter($configArray);

        $this->questionTable = new QuestionTable\Question(
            $this->adapter
        );
        $this->questionMessageTable = new QuestionTable\Question\Message(
            $this->adapter
        );

        $this->dropTable();
        $this->createTable();
    }

    protected function dropTable()
    {
        $sql = file_get_contents($this->sqlPath . 'drop.sql');
        $result = $this->adapter->query($sql)->execute();
    }

    protected function createTable()
    {
        $sql = file_get_contents($this->sqlPath . 'create.sql');
        $result = $this->adapter->query($sql)->execute();
    }

    public function testInitialize()
    {
        $this->assertInstanceOf(
            QuestionTable\Question\Message::class,
            $this->questionMessageTable
        );
    }

    public function testSelectWhereMessageLikeWildcard()
    {
        $result = $this->questionMessageTable->selectWhereMessageLikeWildcard(
            'oba',
            1,
            1
        );
        $results = iterator_to_array($result);
        $this->assertEmpty($results);

        $this->questionTable->insert(
            1,
            'name',
            'subject',
            'foobarbaz'
        );
        $this->questionTable->insert(
            1,
            'name',
            'subject',
            '&lt;b&gt;'
        );

        $result = $this->questionMessageTable->selectWhereMessageLikeWildcard(
            'oba',
            1,
            10
        );
        $results = iterator_to_array($result);
        $this->assertSame(
            $results[0]['question_id'],
            '1'
        );

        $result = $this->questionMessageTable->selectWhereMessageLikeWildcard(
            '&lt;',
            1,
            10
        );
        $results = iterator_to_array($result);
        $this->assertSame(
            $results[0]['question_id'],
            '2'
        );

        $result = $this->questionMessageTable->selectWhereMessageLikeWildcard(
            '&gt;',
            1,
            10
        );
        $results = iterator_to_array($result);
        $this->assertSame(
            $results[0]['question_id'],
            '2'
        );

        $result = $this->questionMessageTable->selectWhereMessageLikeWildcard(
            'hello',
            1,
            10
        );
        $results = iterator_to_array($result);
        $this->assertEmpty($results);
    }

    public function testUpdateWhereQuestionId()
    {
        $this->questionTable->insert(
            1,
            'name',
            'subject',
            'foobarbaz'
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
