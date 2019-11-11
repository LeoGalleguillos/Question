<?php
namespace LeoGalleguillos\Question\Model\Service\Question;

use Generator;
use LeoGalleguillos\Question\Model\Factory as QuestionFactory;
use LeoGalleguillos\Question\Model\Table as QuestionTable;

class Questions
{
    public function __construct(
        QuestionFactory\Question $questionFactory,
        QuestionTable\Question\DeletedDatetimeCreatedDatetime $deletedDatetimeCreatedDatetimeTable
    ) {
        $this->questionFactory                     = $questionFactory;
        $this->deletedDatetimeCreatedDatetimeTable = $deletedDatetimeCreatedDatetimeTable;
    }

    public function getQuestions(int $page): Generator
    {
        $limitOffset   = ($page - 1) * 1000;
        $limitRowCount = 1000;

        $generator = $this->deletedDatetimeCreatedDatetimeTable
            ->selectWhereDeletedDatetimeIsNullOrderByCreatedDatetimeAsc(
                $limitOffset,
                $limitRowCount
            );
        foreach ($generator as $array) {
            yield $this->questionFactory->buildFromArray($array);
        }
    }
}
