<?php
namespace LeoGalleguillos\Question\Model\Service\Question\Delete\Queue;

use LeoGalleguillos\Question\Model\Factory as QuestionFactory;
use LeoGalleguillos\Question\Model\Service as QuestionService;
use LeoGalleguillos\Question\Model\Table as QuestionTable;
use LeoGalleguillos\User\Model\Factory as UserFactory;

class Approve
{
    public function __construct(
        QuestionFactory\Question $questionFactory,
        QuestionService\Question\Delete $deleteService,
        QuestionTable\QuestionEditQueue $questionDeleteQueueTable,
        UserFactory\User $userFactory
    ) {
        $this->questionFactory          = $questionFactory;
        $this->deleteService            = $deleteService;
        $this->questionDeleteQueueTable = $questionDeleteQueueTable;
        $this->userFactory              = $userFactory;
    }

    public function approve(
        int $questionDeleteQueueId
    ) {
        $array = $this->questionDeleteQueueTable->selectWhereQuestionDeleteQueueId(
            $questionDeleteQueueId
        );
        $this->deleteService->delete(
            $this->userFactory->buildFromUserId($array['user_id']),
            $array['reason'],
            $this->questionFactory->buildFromQuestionId($array['question_id'])
        );

        $this->questionDeleteQueueTable->updateSetQueueStatusIdWhereQuestionDeleteQueueId(
            1,
            $questionDeleteQueueId
        );
    }
}
