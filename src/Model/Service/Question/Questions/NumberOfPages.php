<?php
namespace LeoGalleguillos\Question\Model\Service\Question\Questions;

use LeoGalleguillos\Question\Model\Table as QuestionTable;

class NumberOfPages
{
    public function __construct(
        QuestionTable\Question\DeletedDatetime $deletedDatetimeTable
    ) {
        $this->deletedDatetimeTable = $deletedDatetimeTable;
    }

    public function getNumberOfPages(): int
    {
        return ceil(
            $this->deletedDatetimeTable->selectCountWhereDeletedDatetimeIsNull() / 1000
        );
    }
}
