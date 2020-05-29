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

        $questionIds = $this->questionSearchMessageTable
            ->selectQuestionIdWhereMatchAgainst(
                $query,
                ($page - 1) * 100,
                100
            );

        if (empty($questionIds)) {
            $arrays = [];
        } else {
            $arrays = $this->questionTable->selectWhereQuestionIdInAndDeletedDatetimeIsNull(
                $questionIds
            );
        }

        foreach ($arrays as $array) {
            try {
                yield $this->questionFactory->buildFromArray($array);
            } catch (TypeError $typeError) {
                // Do nothing.
            }
        }
    }
}
