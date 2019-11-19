<?php
namespace LeoGalleguillos\Question\Model\Service\Question\Insert;

use LeoGalleguillos\Question\Model\Entity as QuestionEntity;
use LeoGalleguillos\Question\Model\Factory as QuestionFactory;
use LeoGalleguillos\Question\Model\Table as QuestionTable;

class Deleted
{
    public function __construct(
        QuestionFactory\Question $questionFactory,
        QuestionTable\Question $questionTable
    ) {
        $this->questionFactory = $questionFactory;
        $this->questionTable   = $questionTable;
    }

    public function insert(): QuestionEntity\Question {
        $questionId = $this->questionTable->insertDeleted(
            null,
            $_POST['name'],
            $_POST['subject'],
            $_POST['message'],
            $_SERVER['REMOTE_ADDR'],
            $_POST['name'],
            $_SERVER['REMOTE_ADDR'],
            0,
            'foul language'
        );

        return $this->questionFactory->buildFromQuestionId($questionId);
    }
}
