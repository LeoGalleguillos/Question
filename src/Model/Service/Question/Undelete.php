<?php
namespace LeoGalleguillos\Question\Model\Service\Question;

use LeoGalleguillos\Question\Model\Table as QuestionTable;
use LeoGalleguillos\Question\Model\Entity as QuestionEntity;

class Undelete
{
    public function __construct(
        QuestionTable\Question\QuestionId $questionIdTable
    ) {
        $this->questionIdTable = $questionIdTable;
    }

    public function undelete(
        QuestionEntity\Question $questionEntity
    ): bool {
        return (bool) $this->questionIdTable->updateSetDeletedColumnsToNullWhereQuestionId(
            $questionEntity->getQuestionId()
        );
    }
}
