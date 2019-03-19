<?php
namespace LeoGalleguillos\Question\Model\Service\Edit\Queue;

use LeoGalleguillos\Question\Model\Entity as QuestionEntity;
use LeoGalleguillos\Question\Model\Factory as QuestionFactory;
use LeoGalleguillos\Question\Model\Service as QuestionService;
use LeoGalleguillos\Question\Model\Table as QuestionTable;

class Approve
{
    public function __construct(
        QuestionFactory\Question $questionFactory,
        QuestionService\Edit $editService,
        QuestionTable\QuestionEditQueue $questionEditQueueTable
    ) {
        $this->questionFactory        = $questionFactory;
        $this->editService            = $editService;
        $this->questionEditQueueTable = $questionEditQueueTable;
    }

    public function approve(
        int $questionEditQueueId
    ) {
        $array = $this->questionEditQueueTable->selectWhereQuestionEditQueueId(
            $questionEditQueueId
        );
        $this->editService->edit(
            $this->questionFactory->buildFromQuestionId($array['question_id']),
            $array['name'],
            $array['subject'],
            $array['message'],
            $array['user_id'],
            $array['reason']
        );
        $this->questionEditQueueTable->updateSetQueueStatusIdWhereQuestionEditQueueId(
            1,
            $questionEditQueueId
        );
    }
}
