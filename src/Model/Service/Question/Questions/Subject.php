<?php
namespace LeoGalleguillos\Question\Model\Service\Question\Questions;

use Generator;
use LeoGalleguillos\Question\Model\Factory as QuestionFactory;
use LeoGalleguillos\Question\Model\Table as QuestionTable;

class Subject
{
    public function __construct(
        QuestionFactory\Question $questionFactory,
        QuestionTable\Question\SubjectDeletedViewsBrowser $subjectDeletedViewsBrowser
    ) {
        $this->questionFactory            = $questionFactory;
        $this->subjectDeletedViewsBrowser = $subjectDeletedViewsBrowser;
    }

    public function getQuestions(
        string $subject,
        int $page
    ): Generator {
        $arrays = $this->subjectDeletedViewsBrowser->selectWhereSubjectEqualsAndDeletedIsNullOrderByViewsBrowser(
            $subject,
            ($page - 1) * 100,
            100
        );

        foreach ($arrays as $array) {
            yield $this->questionFactory->buildFromArray($array);
        }
    }
}
