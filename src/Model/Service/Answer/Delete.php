<?php
namespace LeoGalleguillos\Question\Model\Service\Answer;

use LeoGalleguillos\Question\Model\Table as QuestionTable;

class Delete
{
    public function __construct(
        QuestionTable\Answer\DeletedDeletedUserIdDeletedReason $deletedDeletedUserIdDeletedReasonTable
    ) {
        $this->deletedDeletedUserIdDeletedReasonTable = $deletedDeletedUserIdDeletedReasonTable;
    }

    public function delete(
        UserEntity\User $userEntity,
        string $reason,
        QuestionEntity\Answer $answerEntity
    ): bool {
        return $this->deletedDeletedUserIdDeletedReasonTable->updateWhereAnswerId(
            $userEntity->getUserId(),
            $reason,
            $answerEntity->getAnswerId()
        );
    }
}
