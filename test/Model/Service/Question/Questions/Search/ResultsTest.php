<?php
namespace LeoGalleguillos\QuestionTest\Model\Service\Question\Questions\Search;

use LeoGalleguillos\Question\Model\Entity as QuestionEntity;
use LeoGalleguillos\Question\Model\Factory as QuestionFactory;
use LeoGalleguillos\Question\Model\Service as QuestionService;
use LeoGalleguillos\Question\Model\Table as QuestionTable;
use MonthlyBasis\String\Model\Service as StringService;
use PHPUnit\Framework\TestCase;

class ResultsTest extends TestCase
{
    protected function setUp(): void
    {
        $this->questionFactoryMock = $this->createMock(
            QuestionFactory\Question::class
        );
        $this->questionTableMock = $this->createMock(
            QuestionTable\Question::class
        );
        $this->questionSearchMessageTable = $this->createMock(
            QuestionTable\QuestionSearchMessage::class
        );
        $this->keepFirstWordsServiceMock = $this->createMock(
            StringService\KeepFirstWords::class
        );

        $this->resultsService = new QuestionService\Question\Questions\Search\Results(
            $this->questionFactoryMock,
            $this->questionTableMock,
            $this->questionSearchMessageTable,
            $this->keepFirstWordsServiceMock
        );
    }

    public function test_getResults()
    {
        $results = $this->resultsService->getResults(
            'the search query',
            7
        );
        $this->assertEmpty(
            iterator_to_array($results)
        );
    }
}
