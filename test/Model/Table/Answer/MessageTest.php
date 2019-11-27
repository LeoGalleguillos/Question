<?php
namespace LeoGalleguillos\QuestionTest\Model\Table\Answer;

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
        $this->sqlPath = $_SERVER['PWD'] . '/sql/leogalle_test/answer/';

        $configArray   = require($_SERVER['PWD'] . '/config/autoload/local.php');
        $configArray   = $configArray['db']['adapters']['leogalle_test'];
        $this->adapter = new Adapter($configArray);

        $this->answerTable = new QuestionTable\Answer(
            $this->adapter
        );
        $this->answerMessageTable = new QuestionTable\Answer\Message(
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
            QuestionTable\Answer\Message::class,
            $this->answerMessageTable
        );
    }

    public function testSelectWhereMessageRegularExpression()
    {
        $result = $this->answerMessageTable->selectWhereMessageRegularExpression(
            'oba',
            1,
            1
        );
        $results = iterator_to_array($result);
        $this->assertEmpty($results);

        $this->answerTable->insert(
            1,
            23094,
            'foobarbaz',
            '1.2.3.4',
            'name',
            '1.2.3.4'
        );
        $this->answerTable->insert(
            1,
            31093,
            '&lt;b&gt;',
            '1.2.3.4',
            'name',
            '1.2.3.4'
        );

        $result = $this->answerMessageTable->selectWhereMessageRegularExpression(
            'oba',
            0,
            10
        );
        $results = iterator_to_array($result);
        $this->assertSame(
            $results[0]['answer_id'],
            '1'
        );

        $result = $this->answerMessageTable->selectWhereMessageRegularExpression(
            '&lt;',
            0,
            10
        );
        $results = iterator_to_array($result);
        $this->assertSame(
            $results[0]['answer_id'],
            '2'
        );

        $result = $this->answerMessageTable->selectWhereMessageRegularExpression(
            '&gt;',
            0,
            10
        );
        $results = iterator_to_array($result);
        $this->assertSame(
            $results[0]['answer_id'],
            '2'
        );

        $result = $this->answerMessageTable->selectWhereMessageRegularExpression(
            'hello',
            0,
            10
        );
        $results = iterator_to_array($result);
        $this->assertEmpty($results);

        $result = $this->answerMessageTable->selectWhereMessageRegularExpression(
            '[A-Za-z0-9]+;',
            0,
            10
        );
        $results = iterator_to_array($result);
        $this->assertSame(
            $results[0]['answer_id'],
            '2'
        );
    }

    public function testUpdateWhereQuestionId()
    {
        $this->answerTable->insert(
            1,
            44422,
            'foobarbaz',
            '1.2.3.4',
            'name',
            '1.2.3.4'
        );

        $this->assertFalse(
            $this->answerMessageTable->updateWhereAnswerId(
                'foobarbaz',
                1
            )
        );
        $this->assertTrue(
            $this->answerMessageTable->updateWhereAnswerId(
                'foo, bar, baz',
                1
            )
        );
        $this->assertFalse(
            $this->answerMessageTable->updateWhereAnswerId(
                'foobarbaz',
                2
            )
        );
    }
}
