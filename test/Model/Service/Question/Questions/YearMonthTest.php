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
        $this->createdDatetimeDeletedViewsBrowserTableMock = $this->createMock(
            QuestionTable\Question\CreatedDatetimeDeletedViewsBrowser::class
        );
        $this->yearMonthService = new QuestionService\Question\Questions\YearMonth(
            $this->questionFactoryMock,
            $this->createdDatetimeDeletedViewsBrowserTableMock
        );
    }

    public function testGetQuestions()
    {
        $this->createdDatetimeDeletedViewsBrowserTableMock
            ->method('selectWhereCreatedDatetimeBetweenAndDeletedIsNullOrderByViewsBrowserDescLimit100')
            ->will(
                $this->onConsecutiveCalls(
                    $this->yieldArrays(),
                    $this->yieldArrays2()
                )
            );
        $this->createdDatetimeDeletedViewsBrowserTableMock
            ->expects($this->exactly(2))
            ->method('selectWhereCreatedDatetimeBetweenAndDeletedIsNullOrderByViewsBrowserDescLimit100')
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

    protected function yieldArrays()
    {
        yield [];
        yield [];
        yield [];
    }

    protected function yieldArrays2()
    {
        yield [];
        yield [];
        yield [];
    }
}
