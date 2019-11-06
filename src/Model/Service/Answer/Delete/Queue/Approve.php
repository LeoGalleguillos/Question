<?php
namespace LeoGalleguillos\Question\Model\Service\Answer\Delete\Queue;

use LeoGalleguillos\Question\Model\Factory as QuestionFactory;
use LeoGalleguillos\Question\Model\Service as QuestionService;
use LeoGalleguillos\Question\Model\Table as QuestionTable;
use LeoGalleguillos\User\Model\Factory as UserFactory;

class Approve
{
    public function __construct(
        QuestionTable\Answer\AnswerId $answerIdTable,
        QuestionTable\AnswerDeleteQueue $answerDeleteQueueTable
    ) {
        $this->answerIdTable          = $answerIdTable;
        $this->answerDeleteQueueTable = $answerDeleteQueueTable;
    }

    public function approve(
        int $answerDeleteQueueId
    ) {
        $array = $this->answerDeleteQueueTable->selectWhereAnswerDeleteQueueId(
            $answerDeleteQueueId
        );

        $this->answerIdTable->updateSetDeletedColumnsWhereAnswerId(
            $array['user_id'],
            $array['reason'],
            $array['answer_id']
        );

        $this->answerDeleteQueueTable->updateSetQueueStatusIdWhereAnswerDeleteQueueId(
            1,
            $answerDeleteQueueId
        );
    }
}
