<?php
namespace LeoGalleguillos\Question\Model\Service\Answer\Edit\Queue;

use LeoGalleguillos\Question\Model\Entity as QuestionEntity;
use LeoGalleguillos\Question\Model\Factory as QuestionFactory;
use LeoGalleguillos\Question\Model\Service as QuestionService;
use LeoGalleguillos\Question\Model\Table as QuestionTable;

class Approve
{
    public function __construct(
        QuestionFactory\Answer $answerFactory,
        QuestionService\Answer\Edit $editService,
        QuestionTable\AnswerEditQueue $answerEditQueueTable
    ) {
        $this->answerFactory        = $answerFactory;
        $this->editService          = $editService;
        $this->answerEditQueueTable = $answerEditQueueTable;
    }

    public function approve(
        int $answerEditQueueId
    ) {
        $array = $this->answerEditQueueTable->selectWhereAnswerEditQueueId(
            $answerEditQueueId
        );
        $this->editService->edit(
            $this->answerFactory->buildFromAnswerId($array['answer_id']),
            $array['name'],
            $array['message'],
            $array['user_id'],
            $array['reason']
        );
        $this->answerEditQueueTable->updateSetQueueStatusIdWhereAnswerEditQueueId(
            1,
            $answerEditQueueId
        );
    }
}
