<?php
namespace LeoGalleguillos\Question\Model\Service\Edit\Queue;

use Generator;
use LeoGalleguillos\Question\Model\Entity as QuestionEntity;
use LeoGalleguillos\Question\Model\Factory as QuestionFactory;
use LeoGalleguillos\Question\Model\Table as QuestionTable;

class Pending
{
    public function __construct(
        QuestionFactory\Question $questionFactory,
        QuestionTable\QuestionEditQueue $questionEditQueueTable
    ) {
        $this->questionFactory        = $questionFactory;
        $this->questionEditQueueTable = $questionEditQueueTable;
    }

    public function getPending(
    ): Generator {
        $generator = $this->questionEditQueueTable->selectWhereQueueStatusId(0);
        foreach ($generator as $array) {
            yield [
                $this->questionFactory->buildFromQuestionId($array['question_id']),
                $this->questionFactory->buildFromArray($array),
            ];
        }
    }
}
