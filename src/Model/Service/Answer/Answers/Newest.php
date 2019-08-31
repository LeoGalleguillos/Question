<?php
namespace LeoGalleguillos\Question\Model\Service\Answer\Answers;

use Generator;
use LeoGalleguillos\Question\Model\Factory as QuestionFactory;
use LeoGalleguillos\Question\Model\Table as QuestionTable;

class Newest
{
    public function __construct(
        QuestionFactory\Answer $answerFactory,
        QuestionTable\Answer\DeletedCreatedDatetime $deletedCreatedDatetimeTable
    ) {
        $this->answerFactory               = $answerFactory;
        $this->deletedCreatedDatetimeTable = $deletedCreatedDatetimeTable;
    }

    public function getNewestAnswers(): Generator
    {
        $generator = $this->deletedCreatedDatetimeTable
            ->selectWhereDeletedIsNullOrderByCreatedDatetimeDesc();

        foreach ($generator as $array) {
            yield $this->answerFactory->buildFromArray($array);
        }
    }
}
