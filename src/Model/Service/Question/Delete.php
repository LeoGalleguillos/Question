<?php
namespace LeoGalleguillos\Question\Model\Service\Question;

use LeoGalleguillos\Question\Model\Table as QuestionTable;
use LeoGalleguillos\Question\Model\Entity as QuestionEntity;
use LeoGalleguillos\User\Model\Entity as UserEntity;

class Delete
{
    public function __construct(
        QuestionTable\Question\QuestionId $questionIdTable
    ) {
        $this->questionIdTable = $questionIdTable;
    }

    public function delete(
        UserEntity\User $userEntity,
        string $reason,
        QuestionEntity\Question $questionEntity
    ): bool {
        return $this->questionIdTable->updateSetDeletedColumnsWhereQuestionId(
            $userEntity->getUserId(),
            $reason,
            $questionEntity->getQuestionId()
        );
    }
}
