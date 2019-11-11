<?php
namespace LeoGalleguillos\Question\Model\Service\Question\Questions\Subject;

use LeoGalleguillos\Question\Model\Table as QuestionTable;

class NumberOfPages
{
    public function __construct(
        QuestionTable\Question\SubjectDeletedDatetimeViewsBrowser $subjectDeletedViewsBrowserTable
    ) {
        $this->subjectDeletedViewsBrowserTable = $subjectDeletedViewsBrowserTable;
    }

    public function getNumberOfPages(
        string $subject
    ): int {
        $count = $this->subjectDeletedViewsBrowserTable->selectCountWhereSubjectEqualsAndDeletedIsNull(
            $subject
        );
        return ceil($count / 100);
    }
}
