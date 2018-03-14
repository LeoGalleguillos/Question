<?php
namespace LeoGalleguillos\Question\Model\Service\Question;

use LeoGalleguillos\Question\Model\Entity as QuestionEntity;
use LeoGalleguillos\Question\Model\Factory as QuestionFactory;
use LeoGalleguillos\Question\Model\Service as QuestionService;
use LeoGalleguillos\Question\Model\Table as QuestionTable;

class Submit
{
    public function __construct(
        QuestionTable\Question $questionTable
    ) {
        $this->questionTable = $questionTable;
    }

    /**
     * Submit.
     */
    public function submit(
        $userId,
        string $subject,
        string $message
    ) {
        $this->questionTable->insert(
            $userId,
            $subject,
            $message
        );
    }
}
