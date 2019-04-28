<?php
namespace LeoGalleguillos\QuestionTest\Model\Table;

use Generator;
use LeoGalleguillos\Memcached\Model\Service as MemcachedService;
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
        $this->memcachedServiceMock = $this->createMock(
            MemcachedService\Memcached::class
        );

        $this->questionTable = new QuestionTable\Question(
            $this->adapter,
            $this->memcachedServiceMock
        );

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
        $this->memcachedServiceMock->method('get')->will($this->onConsecutiveCalls(5, null));
        $this->assertSame(
            5,
            $this->questionTable->selectCount()
        );
        $this->questionTable->insert(1, 'name', 'subject', 'message', '1.2.3.4', 'name', '1.2.3.4');
        $this->questionTable->insert(2, null, 'subject', 'message', '1.2.3.4', 'name', '1.2.3.4');
        $this->questionTable->insert(3, null, 'subject', 'message', '1.2.3.4', 'name', '1.2.3.4');
        $this->assertSame(
            3,
            $this->questionTable->selectCount()
        );
    }

    public function testInsertDeleted()
    {
        $questionId = $this->questionTable->insertDeleted(
            null, 'name', 'subject', 'message', '1.2.3.4', 'name', '1.2.3.4',
            0,
            'foul language'
        );
        $this->assertSame(
            1,
            $questionId
        );

        $array = $this->questionTable->selectWhereQuestionId(1);
        $this->assertSame(
            '0',
            $array['deleted_user_id']
        );
        $this->assertSame(
            'foul language',
            $array['deleted_reason']
        );
    }

    public function testSelectWhereQuestionId()
    {
        $this->questionTable->insert(
            3,
            'name',
            'this is the subject',
            'message',
            '1.2.3.4',
            'name',
            '1.2.3.4'
        );
        $array = $this->questionTable->selectWhereQuestionId(1);
        $this->assertInternalType(
            'array',
            $array
        );
        $this->assertSame(
            '1',
            $array['question_id']
        );
        $this->assertSame(
            '3',
            $array['user_id']
        );
        $this->assertSame(
            'this is the subject',
            $array['subject']
        );
    }

    public function testSelectWhereQuestionIdInAndDeletedIsNull()
    {
        $this->questionTable->insert(
            1, 'name', 'subject', 'message', '1.2.3.4', 'name', '1.2.3.4'
        );
        $this->questionTable->insert(
            2, 'name', 'subject', 'message', '5.6.7.8', 'name', '5.6.7.8'
        );
        $generator = $this->questionTable->selectWhereQuestionIdInAndDeletedIsNull(
            [1, 2, 3, 'string', 'injection' => 'attempt']
        );
        $this->assertInstanceOf(
            Generator::class,
            $generator
        );
        $array = iterator_to_array($generator);
        $this->assertSame(
            2,
            count($array)
        );
    }
}
