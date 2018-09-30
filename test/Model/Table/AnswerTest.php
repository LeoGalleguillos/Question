<?php
namespace LeoGalleguillos\AnswerTest\Model\Table;

use LeoGalleguillos\Question\Model\Table as QuestionTable;
use LeoGalleguillos\QuestionTest\TableTestCase;
use Zend\Db\Adapter\Adapter;
use PHPUnit\Framework\TestCase;

class AnswerTest extends TableTestCase
{
    /**
     * @var string
     */
    protected $sqlPath = __DIR__ . '/../../..' . '/sql/leogalle_test/answer/';

    protected function setUp()
    {
        $configArray     = require(__DIR__ . '/../../../config/autoload/local.php');
        $configArray     = $configArray['db']['adapters']['leogalle_test'];
        $this->adapter   = new Adapter($configArray);

        $this->answerTable = new QuestionTable\Answer($this->adapter);

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
            QuestionTable\Answer::class,
            $this->answerTable
        );
    }

    public function testInsertAndSelectCount()
    {
        $this->assertSame(
            0,
            $this->answerTable->selectCount()
        );
        $this->answerTable->insert(1, 2, null, 'first message');
        $this->answerTable->insert(3, null, 'name', 'second message');
        $this->answerTable->insert(5, 6, null, 'third message');
        $this->assertSame(
            3,
            $this->answerTable->selectCount()
        );
    }

    public function testInsertAnswerIdQuestionIdMessageIp()
    {
        $answerId = $this->answerTable->insertAnswerIdQuestionIdNameMessageIp(
            12345,
            54321,
            'name',
            'message',
            'ip'
        );
        $this->assertSame(
            $answerId,
            12345
        );
    }

    public function testInsertAnswerIdQuestionIdNameMessageIpCreatedNameCreatedIp()
    {
        $answerId = $this->answerTable->insertAnswerIdQuestionIdNameMessageIpCreatedNameCreatedIp(
            12345,
            54321,
            'name',
            'message',
            'ip',
            'name',
            'ip'
        );
        $this->assertSame(
            $answerId,
            12345
        );
    }

    public function testSelectWhereAnswerId()
    {
        $this->answerTable->insert(1, 2, null, 'first message');
        $this->answerTable->insert(3, null, 'name', 'second message');
        $this->answerTable->insert(5, 6, null, 'third message');

        $this->assertSame(
            'first message',
            $this->answerTable->selectWhereAnswerId(1)['message']
        );
        $this->assertSame(
            'third message',
            $this->answerTable->selectWhereAnswerId(3)['message']
        );
    }
}
