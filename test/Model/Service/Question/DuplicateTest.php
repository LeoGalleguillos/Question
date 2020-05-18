<?php
namespace LeoGalleguillos\QuestionTest\Model\Service\Question;

use Exception;
use Laminas\Db\Adapter\Driver\Pdo\Result;
use LeoGalleguillos\Question\Model\Entity as QuestionEntity;
use LeoGalleguillos\Question\Model\Factory as QuestionFactory;
use LeoGalleguillos\Question\Model\Service as QuestionService;
use LeoGalleguillos\Question\Model\Table as QuestionTable;
use LeoGalleguillos\Test\Hydrator as TestHydrator;
use PHPUnit\Framework\TestCase;

class DuplicateTest extends TestCase
{
    protected function setUp(): void
    {
        $this->questionFactoryMock = $this->createMock(
            QuestionFactory\Question::class
        );
        $this->messageDeletedDatetimeCreatedDatetimeTableMock = $this->createMock(
            QuestionTable\Question\MessageDeletedDatetimeCreatedDatetime::class
        );
        $this->duplicateService = new QuestionService\Question\Duplicate(
            $this->questionFactoryMock,
            $this->messageDeletedDatetimeCreatedDatetimeTableMock
        );
    }

    public function test_getDuplicate_emptyResult_throwsException()
    {
        $this->expectException(Exception::class);
        $this->duplicateService->getDuplicate('this is the message');
    }

    public function test_getDuplicate_oneResult_oneQuestionEntity()
    {
        $resultHydrator = new TestHydrator\CountableIterator();
        $resultMock = $this->createMock(
            Result::class
        );
        $resultHydrator->hydrate(
            $resultMock,
            [
                [
                    'question_id' => '12345',
                ]
            ]
        );

        $questionEntity = new QuestionEntity\Question();

        $this->messageDeletedDatetimeCreatedDatetimeTableMock
            ->expects($this->once())
            ->method('selectWhereMessageAndDeletedDatetimeIsNullOrderByCreatedDatetimeDescLimit1')
            ->with('this is the message')
            ->willReturn($resultMock);
        $this->questionFactoryMock
            ->expects($this->once())
            ->method('buildFromArray')
            ->with(['question_id' => '12345'])
            ->willReturn($questionEntity);

        $this->assertSame(
            $questionEntity,
            $this->duplicateService->getDuplicate('this is the message')
        );
    }
}
