<?php
namespace LeoGalleguillos\Question\Model\Service\Question\Delete\Queue;

use LeoGalleguillos\Question\Model\Table as QuestionTable;

class Approve
{
    public function __construct(
        QuestionTable\Question\QuestionId $questionIdTable,
        QuestionTable\QuestionDeleteQueue $questionDeleteQueueTable
    ) {
        $this->questionIdTable          = $questionIdTable;
        $this->questionDeleteQueueTable = $questionDeleteQueueTable;
    }

    public function approve(
        int $questionDeleteQueueId
    ) {
        $array = $this->questionDeleteQueueTable->selectWhereQuestionDeleteQueueId(
            $questionDeleteQueueId
        );

        $this->questionIdTable->updateSetDeletedColumnsWhereQuestionId(
            $array['user_id'],
            $array['reason'],
            $array['question_id']
        );

        $this->questionDeleteQueueTable->updateSetQueueStatusIdWhereQuestionDeleteQueueId(
            1,
            $questionDeleteQueueId
        );
    }
}
