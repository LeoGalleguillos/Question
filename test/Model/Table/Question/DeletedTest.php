<?php
namespace LeoGalleguillos\QuestionTest\Model\Table\Question;

use ArrayObject;
use Exception;
use Generator;
use LeoGalleguillos\Question\Model\Table as QuestionTable;
use LeoGalleguillos\QuestionTest\TableTestCase;
use Zend\Db\Adapter\Adapter;
use PHPUnit\Framework\TestCase;

class DeletedTest extends TableTestCase
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
        $this->questionDeletedTable = new QuestionTable\Question\Deleted(
            $this->adapter,
            $this->questionTable
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
