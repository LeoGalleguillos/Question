<?php
namespace LeoGalleguillos\Question\Model\Service\Question\Questions;

use Generator;
use LeoGalleguillos\Question\Model\Entity as QuestionEntity;
use LeoGalleguillos\Question\Model\Factory as QuestionFactory;
use LeoGalleguillos\Question\Model\Table as QuestionTable;
use TypeError;

class Similar
{
    public function __construct(
        QuestionFactory\Question $questionFactory,
        QuestionTable\Question $questionTable,
        QuestionTable\QuestionSearchMessage $questionSearchMessageTable
    ) {
        $this->questionFactory            = $questionFactory;
        $this->questionTable              = $questionTable;
        $this->questionSearchMessageTable = $questionSearchMessageTable;
    }

    /**
     * @todo Make $maxResults a required parameter
     */
    public function getSimilar(
        QuestionEntity\Question $questionEntity,
        int $maxResults = 12
    ): Generator {
        $query = $questionEntity->getMessage();
        $query = strip_tags($query);
        $query = preg_replace('/\s+/s', ' ', $query);
        $words = explode(' ', $query, 21);
        $query = implode(' ', array_slice($words, 0, 16));
        $query = strtolower($query);

        $questionIdStored = $questionEntity->getQuestionId();

        $result = $this->questionSearchMessageTable
            ->selectQuestionIdWhereMatchAgainstOrderByViewsDescScoreDesc(
                $query,
                0,
                100,
                0,
                $maxResults + 1
            );

        $questionsYielded = 0;

        foreach ($result as $array) {
            if ($questionsYielded >= $maxResults) {
                break;
            }

            if ($array['question_id'] == $questionIdStored) {
                continue;
            }

            $questionEntity = $this->questionFactory->buildFromQuestionId(
                (int) $array['question_id']
            );

            try {
                $questionEntity->getDeletedDatetime();
                continue;
            } catch (TypeError $typeError) {
                // Do nothing.
            }

            yield $questionEntity;
            $questionsYielded++;
        }
    }
}
