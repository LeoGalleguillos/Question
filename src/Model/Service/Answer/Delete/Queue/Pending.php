<?php
namespace LeoGalleguillos\Question\Model\Service\Answer\Delete\Queue;

use Generator;
use LeoGalleguillos\Question\Model\Table as QuestionTable;

class Pending
{
    /**
     * Construct.
     *
     * @param QuestionTable\AnswerEditQueue $answerDeleteQueueTable
     */
    public function __construct(
        QuestionTable\AnswerDeleteQueue $answerDeleteQueueTable
    ) {
        $this->answerDeleteQueueTable = $answerDeleteQueueTable;
    }

    /**
     * Get pending.
     *
     * @return Generator
     * @yield array
     */
    public function getPending(
    ): Generator {
        foreach ($this->answerDeleteQueueTable->selectWhereQueueStatusId(0) as $array) {
            yield $array;
        }
    }
}
