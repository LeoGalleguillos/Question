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
        $questionIds = $this->createdDeletedViewsBrowserTable->selectQuestionIdWhereCreatedInYearAndDeletedIsNull(
            $year
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
