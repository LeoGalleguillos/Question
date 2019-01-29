<?php
namespace LeoGalleguillos\Question\Model\Service\Question\Questions\Subject;

use LeoGalleguillos\Question\Model\Table as QuestionTable;

class NumberOfPages
{
    public function __construct(
        QuestionTable\Question\SubjectDeletedViewsBrowser $subjectDeletedViewsBrowser
    ) {
        $this->subjectDeletedViewsBrowser = $subjectDeletedViewsBrowser;
    }

    public function getNumberOfPages(
        string $subject
    ): int {
        $count = $this->subjectDeletedViewsBrowser->selectCountWhereSubjectEqualsAndDeletedIsNull(
            $subject
        );
        return ceil($count / 100);
    }
}
