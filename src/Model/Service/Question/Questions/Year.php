<?php
namespace LeoGalleguillos\Question\Model\Service\Question\Questions;

use Generator;
use LeoGalleguillos\Question\Model\Factory as QuestionFactory;
use LeoGalleguillos\Question\Model\Table as QuestionTable;
use TypeError;

class Year
{
    public function __construct(
        QuestionFactory\Question $questionFactory,
        QuestionTable\Question\CreatedDeletedViewsBrowser $createdDeletedViewsBrowserTable
    ) {
        $this->questionFactory                 = $questionFactory;
        $this->createdDeletedViewsBrowserTable = $createdDeletedViewsBrowserTable;
    }

    public function getQuestions(
        int $year
    ): Generator {
        $betweenMin = "$year-01-01 05:00:00";
        $betweenMax = ($year + 1) . "-01-01 04:59:59";

        $questionIds = $this->createdDeletedViewsBrowserTable->selectQuestionIdWhereCreatedBetweenAndDeletedIsNull(
            $betweenMin,
            $betweenMax
        );

        foreach ($questionIds as $questionId) {
            $questionEntity = $this->questionFactory->buildFromQuestionId($questionId);
            try {
                $questionEntity->getDeleted();
            } catch (TypeError $typeError) {
                yield $questionEntity;
            }
        }
    }
}
