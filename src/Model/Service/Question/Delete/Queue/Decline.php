<?php
namespace LeoGalleguillos\Question\Model\Service\Question\Delete\Queue;

use LeoGalleguillos\Question\Model\Table as QuestionTable;

class Decline
{
    public function __construct(
        QuestionTable\QuestionDeleteQueue $questionDeleteQueueTable
    ) {
        $this->questionDeleteQueueTable = $questionDeleteQueueTable;
    }

    public function decline(
        int $questionDeleteQueueId
    ) {
        $this->questionDeleteQueueTable->updateSetQueueStatusIdWhereQuestionDeleteQueueId(
            -1,
            $questionDeleteQueueId
        );
    }
}
