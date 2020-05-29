<?php
namespace LeoGalleguillos\Question\Model\Service\Question\Questions\Search;

use LeoGalleguillos\Question\Model\Factory as QuestionFactory;
use LeoGalleguillos\Question\Model\Table as QuestionTable;
use LeoGalleguillos\String\Model\Service as StringService;
use TypeError;

class Results
{
    public function __construct(
        QuestionFactory\Question $questionFactory,
        QuestionTable\Question $questionTable,
        QuestionTable\QuestionSearchMessage $questionSearchMessageTable,
        StringService\KeepFirstWords $keepFirstWordsService
    ) {
        $this->questionFactory            = $questionFactory;
        $this->questionTable              = $questionTable;
        $this->questionSearchMessageTable = $questionSearchMessageTable;
        $this->keepFirstWordsService      = $keepFirstWordsService;
    }

    public function getResults(string $query, int $page)
    {
        $query = strtolower($query);
        $query = $this->keepFirstWordsService->keepFirstWords(
            $query,
            16
        );

        $result = $this->questionSearchMessageTable
            ->selectQuestionIdWhereMatchAgainstOrderByViewsDescScoreDesc(
                $query,
                ($page - 1) * 100,
                100
            );

        foreach ($result as $array) {
            $questionEntity = $this->questionFactory->buildFromQuestionId($array['question_id']);

            try {
                $questionEntity->getDeletedDatetime();
                continue;
            } catch (TypeError $typeError) {
                // Do nothing.
            }

            yield $questionEntity;
        }
    }
}
