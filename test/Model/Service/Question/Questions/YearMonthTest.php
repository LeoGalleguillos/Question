<?php
namespace LeoGalleguillos\QuestionTest\Model\Service;

use Generator;
use LeoGalleguillos\Question\Model\Factory as QuestionFactory;
use LeoGalleguillos\Question\Model\Service as QuestionService;
use LeoGalleguillos\Question\Model\Table as QuestionTable;
use PHPUnit\Framework\TestCase;

class YearMonthTest extends TestCase
{
    protected function setUp()
    {
        $this->questionFactoryMock = $this->createMock(
            QuestionFactory\Question::class
        );
        $this->createdDeletedViewsBrowserTableMock = $this->createMock(
            QuestionTable\Question\CreatedDeletedViewsBrowser::class
        );
        $this->yearMonthService = new QuestionService\Question\Questions\YearMonth(
            $this->questionFactoryMock,
            $this->createdDeletedViewsBrowserTableMock
        );
    }

    public function testGetQuestions()
    {
        $this->createdDeletedViewsBrowserTableMock
            ->method('selectQuestionIdWhereCreatedBetweenAndDeletedIsNull')
            ->will(
                $this->onConsecutiveCalls(
                    $this->yieldQuestionIds(),
                    $this->yieldQuestionIds2()
                )
            );
        $this->createdDeletedViewsBrowserTableMock
            ->expects($this->exactly(2))
            ->method('selectQuestionIdWhereCreatedBetweenAndDeletedIsNull')
            ->withConsecutive(
            ['2017-07-01 04:00:00', '2017-08-01 03:59:59'],
            ['2006-11-01 05:00:00', '2006-12-01 04:59:59']
        );

        $generator = $this->yearMonthService->getQuestions(
            2017,
            7
        );
        iterator_to_array($generator);

        $generator = $this->yearMonthService->getQuestions(
            2006,
            11
        );
        iterator_to_array($generator);
    }

    protected function yieldQuestionIds()
    {
        yield 1;
        yield 22;
        yield 333;
    }

    protected function yieldQuestionIds2()
    {
        yield 1;
        yield 22;
        yield 333;
    }
}
