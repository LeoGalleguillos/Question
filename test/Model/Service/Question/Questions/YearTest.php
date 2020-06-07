<?php
namespace LeoGalleguillos\QuestionTest\Model\Service;

use Generator;
use Laminas\Db as LaminasDb;
use LeoGalleguillos\Question\Model\Factory as QuestionFactory;
use LeoGalleguillos\Question\Model\Service as QuestionService;
use LeoGalleguillos\Question\Model\Table as QuestionTable;
use PHPUnit\Framework\TestCase;

class YearTest extends TestCase
{
    protected function setUp(): void
    {
        $this->sqlMock = $this->createMock(
            LaminasDb\Sql\Sql::class
        );
        $this->questionFactoryMock = $this->createMock(
            QuestionFactory\Question::class
        );
        $this->questionTableMock = $this->createMock(
            QuestionTable\Question::class
        );
        $this->yearService = new QuestionService\Question\Questions\Year(
            $this->sqlMock,
            $this->questionFactoryMock,
            $this->questionTableMock
        );
    }

    public function test_getQuestions()
    {
        $generator = $this->yearService->getQuestions(2020);
        $this->assertInstanceOf(
            Generator::class,
            $generator
        );
    }
}
