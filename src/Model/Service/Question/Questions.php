<?php
namespace LeoGalleguillos\Question\Model\Service\Question;

use Generator;
use LeoGalleguillos\Question\Model\Factory as QuestionFactory;
use LeoGalleguillos\Question\Model\Table as QuestionTable;

class Questions
{
    public function __construct(
        QuestionFactory\Question $questionFactory,
        QuestionTable\Question\DeletedCreatedDatetime $deletedCreatedDatetimeTable
    ) {
        $this->questionFactory             = $questionFactory;
        $this->deletedCreatedDatetimeTable = $deletedCreatedDatetimeTable;
    }

    public function getQuestions(int $page): Generator
    {
        $limitOffset   = ($page - 1) * 1000;
        $limitRowCount = 1000;

        $generator = $this->deletedCreatedDatetimeTable->selectWhereDeletedIsNullOrderByCreatedDatetimeAsc(
            $limitOffset,
            $limitRowCount
        );
        foreach ($generator as $array) {
            yield $this->questionFactory->buildFromArray();
        }
    }
}
