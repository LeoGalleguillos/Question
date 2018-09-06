<?php
namespace LeoGalleguillos\QuestionTest\Model\Table;

use ArrayObject;
use Exception;
use Generator;
use LeoGalleguillos\Question\Model\Table as QuestionTable;
use LeoGalleguillos\QuestionTest\TableTestCase;
use Zend\Db\Adapter\Adapter;
use PHPUnit\Framework\TestCase;

class QuestionHistoryTest extends TableTestCase
{
    /**
     * @var string
     */
    protected $sqlPath;

    protected function setUp()
    {
        $this->sqlPath   = $_SERVER['PWD'] . '/sql/leogalle_test/question_history/';
        $configArray     = require(__DIR__ . '/../../../config/autoload/local.php');
        $configArray     = $configArray['db']['adapters']['leogalle_test'];
        $this->adapter   = new Adapter($configArray);

        $this->questionHistoryTable      = new QuestionTable\QuestionHistory($this->adapter);

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
            QuestionTable\QuestionHistory::class,
            $this->questionHistoryTable
        );
    }

    public function testInsertSelectFromQuestion()
    {
        $questionHistoryId = $this->questionHistoryTable->insertSelectFromQuestion(
            'note',
            123
        );
        $this->assertSame(
            $questionHistoryId,
            0
        );
    }
}
