<?php
namespace LeoGalleguillos\Question\Model\Service\Answer;

use LeoGalleguillos\Question\Model\Table as QuestionTable;
use LeoGalleguillos\Question\Model\Entity as QuestionEntity;

class Undelete
{
    public function __construct(
        QuestionTable\Answer\AnswerId $answerIdTable
    ) {
        $this->answerIdTable = $answerIdTable;
    }

    public function undelete(
        QuestionEntity\Answer $answerEntity
    ): bool {
        return (bool) $this->answerIdTable->updateSetDeletedDeletedUserIdDeletedReasonToNullWhereAnswerId(
            $answerEntity->getAnswerId()
        );
    }
}
