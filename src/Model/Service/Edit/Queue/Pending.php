<?php
namespace LeoGalleguillos\Question\Model\Service\Edit\Queue;

use Generator;
use LeoGalleguillos\Question\Model\Factory as QuestionFactory;
use LeoGalleguillos\Question\Model\Table as QuestionTable;

class Pending
{
    /**
     * Construct.
     *
     * @param QuestionFactory\Question $questionFactory
     * @param QuestionTable\QuestionEditQueue $questionEditQueueTable
     */
    public function __construct(
        QuestionFactory\Question $questionFactory,
        QuestionTable\QuestionEditQueue $questionEditQueueTable
    ) {
        $this->questionFactory        = $questionFactory;
        $this->questionEditQueueTable = $questionEditQueueTable;
    }

    /**
     * Get pending.
     *
     * @return Generator
     * @yield array
     */
    public function getPending(
    ): Generator {
        $generator = $this->questionEditQueueTable->selectWhereQueueStatusId(0);
        foreach ($generator as $array) {
            yield [
                'currentQuestionEntity' => $this->questionFactory->buildFromQuestionId($array['question_id']),
                'newQuestionEntity'     => $this->questionFactory->buildFromArray($array),
                'reason'                => $array['reason'],
                'questionEditQueueId'   => $array['question_edit_queue_id'],
            ];
        }
    }
}
