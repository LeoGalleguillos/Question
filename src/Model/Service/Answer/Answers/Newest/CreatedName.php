<?php
namespace LeoGalleguillos\Question\Model\Service\Answer\Answers\Newest;

use Generator;
use LeoGalleguillos\Question\Model\Factory as QuestionFactory;
use LeoGalleguillos\Question\Model\Table as QuestionTable;

class CreatedName
{
    public function __construct(
        QuestionFactory\Answer $answerFactory,
        QuestionTable\Answer\CreatedName $answerCreatedNameTable
    ) {
        $this->answerFactory          = $answerFactory;
        $this->answerCreatedNameTable = $answerCreatedNameTable;
    }

    public function getNewestAnswers(
        string $createdName,
        int $limitRowCount
    ): Generator {
        $generator = $this->answerCreatedNameTable->selectWhereCreatedName(
            $createdName,
            $limitRowCount
        );

        foreach ($generator as $array) {
            yield $this->answerFactory->buildFromArray($array);
        }
    }
}
