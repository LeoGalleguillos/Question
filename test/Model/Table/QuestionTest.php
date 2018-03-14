<?php
namespace LeoGalleguillos\QuestionTest\Model\Table;

use ArrayObject;
use Exception;
use Generator;
use LeoGalleguillos\Question\Model\Table as QuestionTable;
use LeoGalleguillos\QuestionTest\TableTestCase;
use Zend\Db\Adapter\Adapter;
use PHPUnit\Framework\TestCase;

class QuestionTest extends TableTestCase
{
    /**
     * @var string
     */
    protected $sqlPath = __DIR__ . '/../../..' . '/sql/leogalle_test/question/';

    protected function setUp()
    {
        $configArray     = require(__DIR__ . '/../../../config/autoload/local.php');
        $configArray     = $configArray['db']['adapters']['leogalle_test'];
        $this->adapter   = new Adapter($configArray);

        $this->questionTable      = new QuestionTable\Question($this->adapter);

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
            QuestionTable\Question::class,
            $this->questionTable
        );
    }

    public function testInsertAndSelectCount()
    {
        $this->assertSame(
            0,
            $this->questionTable->selectCount()
        );
        $this->questionTable->insert(1, 'subject', 'message');
        $this->questionTable->insert(2, 'subject', 'message');
        $this->questionTable->insert(3, 'subject', 'message');
        $this->assertSame(
            3,
            $this->questionTable->selectCount()
        );
    }

    public function testSelectWhereUserId()
    {
        $this->questionTable->insert(1, 'subject', 'message');
        $array = $this->questionTable->selectWhereQuestionId(1);
        $this->assertInternalType(
            'array',
            $array
        );
    }
}
