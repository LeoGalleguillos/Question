<?php
namespace LeoGalleguillos\Question\Model\Service\Question\Questions;

use LeoGalleguillos\Question\Model\Table as QuestionTable;

class NumberOfPages
{
    public function __construct(
        QuestionTable\Question\Deleted $deletedTable
    ) {
        $this->deletedTable = $deletedTable;
    }

    public function getNumberOfPages(): int
    {
        return ceil(
            $this->deletedTable->selectCountWhereDeletedIsNull() / 1000
        );
    }
}
