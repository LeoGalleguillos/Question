<?php
namespace LeoGalleguillos\Question\Model\Service\Answer\Insert;

use LeoGalleguillos\Question\Model\Entity as QuestionEntity;
use LeoGalleguillos\Question\Model\Factory as QuestionFactory;
use LeoGalleguillos\Question\Model\Table as QuestionTable;

class Visitor
{
    public function __construct(
        QuestionFactory\Answer $answerFactory,
        QuestionTable\Answer $answerTable
    ) {
        $this->answerFactory = $answerFactory;
        $this->answerTable   = $answerTable;
    }

    public function insert(): QuestionEntity\Answer
    {
        $answerId = $this->answerTable->insert(
            $_POST['question-id'],
            null,
            $_POST['message'],
            $_SERVER['REMOTE_ADDR'],
            $_POST['name'],
            $_SERVER['REMOTE_ADDR']
        );

        return $this->answerFactory->buildFromAnswerId($answerId);
    }
}
