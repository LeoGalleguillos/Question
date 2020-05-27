<?php
namespace LeoGalleguillos\QuestionTest\Model\Table;

use Generator;
use LeoGalleguillos\Question\Model\Table as QuestionTable;
use LeoGalleguillos\QuestionTest\TableTestCase;
use Zend\Db\Adapter\Adapter;
use PHPUnit\Framework\TestCase;

class QuestionEditQueueTest extends TableTestCase
{
    /**
     * @var string
     */
    protected $sqlPath;

    protected function setUp(): void
    {
        $this->sqlPath = $_SERVER['PWD'] . '/sql/test/question_edit_queue/';
        $configArray   = require(__DIR__ . '/../../../config/autoload/local.php');
        $configArray   = $configArray['db']['adapters']['test'];
        $this->adapter = new Adapter($configArray);

        $this->questionEditQueueTable = new QuestionTable\QuestionEditQueue($this->adapter);

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
            QuestionTable\QuestionEditQueue::class,
            $this->questionEditQueueTable
        );
    }

    public function testInsert()
    {
        $questionEditQueueId = $this->questionEditQueueTable->insert(
            12345,
            1,
            'name',
            'subject',
            'message',
            'ip',
            'reason'
        );
        $this->assertSame(
            $questionEditQueueId,
            1
        );
        $questionEditQueueId = $this->questionEditQueueTable->insert(
            67890,
            1,
            'name',
            'subject',
            'message',
            'ip',
            'reason'
        );
        $this->assertSame(
            $questionEditQueueId,
            2
        );
    }
}
