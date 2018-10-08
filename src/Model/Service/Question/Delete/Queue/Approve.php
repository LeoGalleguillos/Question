<?php
namespace LeoGalleguillos\Question\Model\Service\Question\Delete\Queue;

use LeoGalleguillos\Question\Model\Factory as QuestionFactory;
use LeoGalleguillos\Question\Model\Service as QuestionService;
use LeoGalleguillos\Question\Model\Table as QuestionTable;
use LeoGalleguillos\User\Model\Factory as UserFactory;

class Approve
{
    public function __construct(
        QuestionTable\Question\DeletedDeletedUserIdDeletedReason $deletedDeletedUserIdDeletedReasonTable,
        QuestionTable\QuestionDeleteQueue $questionDeleteQueueTable
    ) {
        $this->deletedDeletedUserIdDeletedReasonTable = $deletedDeletedUserIdDeletedReasonTable;
        $this->questionDeleteQueueTable               = $questionDeleteQueueTable;
    }

    public function approve(
        int $questionDeleteQueueId
    ) {
        $array = $this->questionDeleteQueueTable->selectWhereQuestionDeleteQueueId(
            $questionDeleteQueueId
        );

        $this->deletedDeletedUserIdDeletedReasonTable->updateSetDeletedDeletedUserIdDeletedReasonWhereQuestionId(
            $array['created'],
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
