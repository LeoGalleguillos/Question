<?php
namespace LeoGalleguillos\Question\Model\Service\Question\Questions;

use LeoGalleguillos\Question\Model\Factory as QuestionFactory;
use LeoGalleguillos\Question\Model\Table as QuestionTable;

class Similar
{
    public function __construct(
        QuestionFactory\Question $questionFactory,
        QuestionTable\Question $questionTable,
        QuestionTable\QuestionSearchMessage $questionSearchMessageTable
    ) {
        $this->questionFactory                = $questionFactory;
        $this->questionTable              = $questionTable;
        $this->questionSearchMessageTable = $questionSearchMessageTable;
    }

    public function getSimilar(
        QuestionEntity\Question $questionEntity
    ): array {
        $query = $questionEntity->getMessage();
        $query = strip_tags($query);
        $query = preg_replace('/\s+/s', ' ', $query);
        $words = explode(' ', $query, 21);
        $query = implode(' ', array_slice($words, 0, 16));
        $query = strtolower($query);

        $questionIds = $this->questionSearchMessageTable->selectQuestionIdWhereMatchAgainst(
            $query,
            0,
            11
        );

        $key = array_search($questionEntity->getQuestionId(), $questionIds);
        if ($key !== false) {
            unset($questionIds[$key]);
        }

        if (empty($questionIds)) {
            return [];
        }

        $arrays = $this->questionTable->selectWhereQuestionIdInAndDeletedIsNull(
            $questionIds
        );

        $similarQuestions = [];
        foreach ($arrays as $array) {
            $similarQuestions[] = $this->questionFactory->buildFromArray($array);
        }
        return $similarQuestions;
    }
}
