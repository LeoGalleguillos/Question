<?php
namespace LeoGalleguillos\Question\Model\Service\Answer;

use LeoGalleguillos\Question\Model\Table as QuestionTable;
use LeoGalleguillos\Question\Model\Entity as QuestionEntity;
use MonthlyBasis\User\Model\Entity as UserEntity;

class Delete
{
    public function __construct(
        QuestionTable\Answer\AnswerId $answerIdTable
    ) {
        $this->answerIdTable = $answerIdTable;
    }

    public function delete(
        UserEntity\User $userEntity,
        string $reason,
        QuestionEntity\Answer $answerEntity
    ): bool {
        return (bool) $this->answerIdTable->updateSetDeletedColumnsWhereAnswerId(
            $userEntity->getUserId(),
            $reason,
            $answerEntity->getAnswerId()
        );
    }
}
