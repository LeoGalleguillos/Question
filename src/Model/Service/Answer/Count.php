<?php
namespace LeoGalleguillos\Question\Model\Service\Answer;

use LeoGalleguillos\Question\Model\Entity as QuestionEntity;
use LeoGalleguillos\Question\Model\Table as QuestionTable;

class Count
{
    public function __construct(
        QuestionTable\Answer $answerTable
    ) {
        $this->answerTable   = $answerTable;
    }

    /**
     * Get count.
     *
     * @param QuestionEntity\Question $questionEntity
     * @return int
     */
    public function getCount(
        QuestionEntity\Question $questionEntity
    ) : int {
        return $this->answerTable->selectCountWhereQuestionId(
            $questionEntity->getQuestionId()
        );
    }
}
