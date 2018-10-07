<?php
namespace LeoGalleguillos\Question\Model\Service\Answer\Delete\Queue;

use LeoGalleguillos\Question\Model\Table as QuestionTable;
use LeoGalleguillos\Question\Model\Entity as QuestionEntity;
use LeoGalleguillos\User\Model\Entity as UserEntity;

class Add
{
    public function __construct(
        QuestionTable\AnswerDeleteQueue $answerDeleteQueueTable
    ) {
        $this->answerDeleteQueueTable = $answerDeleteQueueTable;
    }

    public function add(
        UserEntity\User $userEntity,
        QuestionEntity\Answer $answerEntity,
        string $reason
    ): bool {
        return (bool) $this->answerDeleteQueueTable->insert(
            $answerEntity->getAnswerId(),
            $userEntity->getUserId(),
            $reason
        );
    }
}
