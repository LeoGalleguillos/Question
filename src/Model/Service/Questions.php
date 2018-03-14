<?php
namespace LeoGalleguillos\Question\Model\Service;

use Generator;
use LeoGalleguillos\Question\Model\Entity as QuestionEntity;
use LeoGalleguillos\Question\Model\Factory as QuestionFactory;
use LeoGalleguillos\Question\Model\Service as QuestionService;
use LeoGalleguillos\Question\Model\Table as QuestionTable;

class Questions
{
    public function __construct(
        QuestionFactory\Question $questionFactory,
        QuestionTable\Question $questionTable
    ) {
        $this->questionFactory = $questionFactory;
        $this->questionTable   = $questionTable;
    }

    /**
     * Get quesstions.
     *
     * @yield QuestionEntity\Question
     * @return Generator
     */
    public function getQuestions() : Generator
    {
        $generator = $this->questionTable->selectOrderByCreatedDesc();
        foreach ($generator as $array) {
            yield $this->questionFactory->buildFromArray($array);
        }
    }
}
