<?php
namespace LeoGalleguillos\Question\Model\Service\Question\Questions;

use LeoGalleguillos\Question\Model\Table as QuestionTable;

class NumberOfPages
{
    public function __construct(
        QuestionTable\Question $questionTable
    ) {
        $this->questionTable = $questionTable;
    }

    public function getNumberOfPages(): int
    {
        return ceil($this->questionTable->selectCount() / 1000);
    }
}
