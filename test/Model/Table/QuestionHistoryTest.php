<?php
namespace LeoGalleguillos\QuestionTest\Model\Table;

use ArrayObject;
use Exception;
use Generator;
use LeoGalleguillos\Memcached\Model\Service as MemcachedService;
use LeoGalleguillos\Question\Model\Table as QuestionTable;
use LeoGalleguillos\QuestionTest\TableTestCase;
use Zend\Db\Adapter\Adapter;
use PHPUnit\Framework\TestCase;
use TypeError;

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

        $this->questionTable = new QuestionTable\Question(
            $this->adapter,
            new MemcachedService\Memcached()
        );
        $this->questionHistoryTable = new QuestionTable\QuestionHistory($this->adapter);

        $this->setForeignKeyChecks0();
        $this->dropTables();
        $this->createTables();
        $this->setForeignKeyChecks1();
    }

    protected function dropTables()
    {
        $sql = file_get_contents($this->sqlPath . 'drop.sql');
        $result = $this->adapter->query($sql)->execute();

        $sql = file_get_contents($_SERVER['PWD'] . '/sql/leogalle_test/question/drop.sql');
        $this->adapter->query($sql)->execute();
    }

    protected function createTables()
    {
        $sql = file_get_contents($this->sqlPath . 'create.sql');
        $result = $this->adapter->query($sql)->execute();

        $sql = file_get_contents($_SERVER['PWD'] . '/sql/leogalle_test/question/create.sql');
        $this->adapter->query($sql)->execute();
    }

    public function testInsertSelectFromQuestion()
    {
        $questionHistoryId = $this->questionHistoryTable->insertSelectFromQuestion(
            'reason',
            123
        );
        $this->assertSame(
            $questionHistoryId,
            0
        );
    }

    public function testSelectWhereQuestionIdOrderByCreatedAscLimit1()
    {
        try {
            $array = $this->questionHistoryTable->selectWhereQuestionIdOrderByCreatedAscLimit1(
                1
            );
            $this->fail();
        } catch (TypeError $typeError) {
            $this->assertTrue(true);
        }

        $questionId = $this->questionTable->insert(
            12345,
            'this is the subject',
            'this is the message message',
            'this is the name',
            '1.2.3.4'
        );
        $questionHistoryId = $this->questionHistoryTable->insertSelectFromQuestion(
            'reason',
            1
        );
        $array = $this->questionHistoryTable->selectWhereQuestionIdOrderByCreatedAscLimit1(
            1
        );
        $this->assertSame(
            'this is the subject',
            $array['subject']
        );
        $this->assertSame(
            'this is the name',
            $array['name']
        );
    }
}
