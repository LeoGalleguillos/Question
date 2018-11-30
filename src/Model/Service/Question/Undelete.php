<?php
namespace LeoGalleguillos\Question\Model\Service\Question;

use LeoGalleguillos\Question\Model\Table as QuestionTable;
use LeoGalleguillos\Question\Model\Entity as QuestionEntity;

class Undelete
{
    public function __construct(
        QuestionTable\Question\DeletedDeletedUserIdDeletedReason $deletedDeletedUserIdDeletedReasonTable
    ) {
        $this->deletedDeletedUserIdDeletedReasonTable = $deletedDeletedUserIdDeletedReasonTable;
    }

    public function undelete(
        QuestionEntity\Question $questionEntity
    ): bool {
        return (bool) $this->deletedDeletedUserIdDeletedReasonTable->updateToNullWhereQuestionId(
            $questionEntity->getQuestionId()
        );
    }
}
