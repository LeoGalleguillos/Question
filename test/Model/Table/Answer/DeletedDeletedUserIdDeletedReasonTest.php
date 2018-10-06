<?php
namespace LeoGalleguillos\QuestionTest\Model\Table\Answer;

use LeoGalleguillos\Question\Model\Table as QuestionTable;
use LeoGalleguillos\QuestionTest\TableTestCase;
use Zend\Db\Adapter\Adapter;
use PHPUnit\Framework\TestCase;

class DeletedDeletedUserIdDeletedReasonTest extends TableTestCase
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
        $this->answerDeletedDeletedUserIdDeletedReasonTable = new QuestionTable\Answer\DeletedDeletedUserIdDeletedReason(
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
            QuestionTable\Answer\DeletedDeletedUserIdDeletedReason::class,
            $this->answerDeletedDeletedUserIdDeletedReasonTable
        );
    }

    public function testUpdateWhereAnswerId()
    {
        $this->assertFalse(
            $this->answerDeletedDeletedUserIdDeletedReasonTable->updateWhereAnswerId(
                1,
                'reason',
                1
            )
        );
    }
}
