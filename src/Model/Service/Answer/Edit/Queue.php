<?php
namespace LeoGalleguillos\Question\Model\Service\Answer\Edit;

use LeoGalleguillos\Question\Model\Entity as QuestionEntity;
use LeoGalleguillos\Question\Model\Table as QuestionTable;
use LeoGalleguillos\User\Model\Entity as UserEntity;

class Queue
{
    public function __construct(
        QuestionTable\AnswerEditQueue $answerEditQueueTable
    ) {
        $this->answerEditQueueTable = $answerEditQueueTable;
    }

    public function queue(
        QuestionEntity\Answer $answerEntity,
        UserEntity\User $userEntity,
        string $name = null,
        string $message,
        string $ip,
        string $reason
    ) {
        $answerEditQueueId = $this->answerEditQueueTable->insert(
            $answerEntity->getAnswerId(),
            $userEntity->getUserId(),
            $name,
            $message,
            $ip,
            $reason
        );
    }
}
