<?php
namespace LeoGalleguillos\Question\Model\Service\Answer;

use Generator;
use LeoGalleguillos\Question\Model\Entity as QuestionEntity;
use LeoGalleguillos\Question\Model\Factory as QuestionFactory;
use LeoGalleguillos\Question\Model\Service as QuestionService;
use LeoGalleguillos\Question\Model\Table as QuestionTable;

class Answers
{
    public function __construct(
        QuestionFactory\Answer $answerFactory,
        QuestionTable\Answer $answerTable
    ) {
        $this->answerFactory = $answerFactory;
        $this->answerTable   = $answerTable;
    }

    /**
     * Get answers.
     *
     * @param QuestionEntity\Question $questionEntity
     * @yield QuestionEntity\Answer
     * @return Generator
     */
    public function submit(
        QuestionEntity\Question $questionEntity
    ) : Generator {
        $arrays = $this->answerTable->selectWhereQuestionId(
            $questionEntity->getQuestionId()
        );
        foreach ($arrays as $array) {
            yield $this->answerFactory->buildFromArray($array);
        }
    }
}
