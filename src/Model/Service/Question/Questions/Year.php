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
        QuestionTable\Question\CreatedDeleted $createdDeletedTable
    ) {
        $this->questionFactory     = $questionFactory;
        $this->createdDeletedTable = $createdDeletedTable;
    }

    public function getQuestions(
        int $year
    ): Generator {
        $questionIds = $this->createdDeletedTable->selectQuestionIdWhereCreatedInYearAndDeletedIsNull(
            $year
        );

        foreach ($questionsIds as $questionId) {
            $questionEntity = $this->questionFactory->buildFromQuestionId($questionIds);
            try {
                $questionEntity->getDeleted();
            } catch (TypeError $typeError) {
                yield $questionEntity;
            }
        }
    }
}
