<?php
namespace LeoGalleguillos\Question\Model\Service\Question\Edit\Queue;

use LeoGalleguillos\Question\Model\Table as QuestionTable;

class Decline
{
    public function __construct(
        QuestionTable\QuestionEditQueue $questionEditQueueTable
    ) {
        $this->questionEditQueueTable = $questionEditQueueTable;
    }

    public function decline(
        int $questionEditQueueId
    ) {
        $this->questionEditQueueTable->updateSetQueueStatusIdWhereQuestionEditQueueId(
            -1,
            $questionEditQueueId
        );
    }
}
