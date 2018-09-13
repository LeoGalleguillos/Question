<?php
namespace LeoGalleguillos\Question\Model\Service\Answer\Edit\Queue;

use Generator;
use LeoGalleguillos\Question\Model\Factory as QuestionFactory;
use LeoGalleguillos\Question\Model\Table as QuestionTable;

class Pending
{
    /**
     * Construct.
     *
     * @param QuestionFactory\Answer $answerFactory
     * @param QuestionTable\QuestionEditQueue $answerEditQueueTable
     */
    public function __construct(
        QuestionFactory\Answer $answerFactory,
        QuestionTable\AnswerEditQueue $answerEditQueueTable
    ) {
        $this->answerFactory        = $answerFactory;
        $this->answerEditQueueTable = $answerEditQueueTable;
    }

    /**
     * Get pending.
     *
     * @return Generator
     * @yield array
     */
    public function getPending(
    ): Generator {
        $generator = $this->answerEditQueueTable->selectWhereQueueStatusId(0);
        foreach ($generator as $array) {
            yield [
                'currentAnswerEntity' => $this->answerFactory->buildFromAnswerId($array['answer_id']),
                'newAnswerEntity'     => $this->answerFactory->buildFromArray($array),
                'reason'                => $array['reason'],
                'answerEditQueueId'   => $array['answer_edit_queue_id'],
            ];
        }
    }
}
