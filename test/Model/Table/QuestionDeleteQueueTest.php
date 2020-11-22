<?php
namespace LeoGalleguillos\QuestionTest\Model\Table;

use Generator;
use LeoGalleguillos\Question\Model\Table as QuestionTable;
use LeoGalleguillos\QuestionTest\TableTestCase;
use Laminas\Db\Adapter\Adapter;
use PHPUnit\Framework\TestCase;

class QuestionDeleteQueueTest extends TableTestCase
{
    /**
     * @var string
     */
    protected $sqlPath;

    protected function setUp(): void
    {
        $this->sqlPath = $_SERVER['PWD'] . '/sql/test/question_delete_queue/';
        $configArray   = require(__DIR__ . '/../../../config/autoload/local.php');
        $configArray   = $configArray['db']['adapters']['test'];
        $this->adapter = new Adapter($configArray);

        $this->questionDeleteQueueTable = new QuestionTable\QuestionDeleteQueue($this->adapter);

        $this->setForeignKeyChecks0();
        $this->dropTable();
        $this->createTable();
        $this->setForeignKeyChecks1();
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
            QuestionTable\QuestionDeleteQueue::class,
            $this->questionDeleteQueueTable
        );
    }

    public function testInsert()
    {
        $answerEditQueueId = $this->questionDeleteQueueTable->insert(
            12345,
            54321,
            'reason'
        );
        $this->assertSame(
            $answerEditQueueId,
            1
        );
        $answerEditQueueId = $this->questionDeleteQueueTable->insert(
            12345,
            54321,
            'reason'
        );
        $this->assertSame(
            $answerEditQueueId,
            2
        );
    }
}
