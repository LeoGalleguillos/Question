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
     * Get questions.
     *
     * @param int $page
     * @param int $questionsPerPage
     * @return Generator
     * @yield QuestionEntity\Question
     */
    public function getQuestions(
        int $page,
        int $questionsPerPage = 100
    ): Generator {
        if ($page > 50) {
            throw new Exception('Invalid page number.');
        }

        $generator = $this->questionTable
            ->selectWhereDeletedIsNullOrderByCreatedDateTimeDesc(
                ($page - 1) * $questionsPerPage,
                $questionsPerPage
            );
        foreach ($generator as $array) {
            yield $this->questionFactory->buildFromArray($array);
        }
    }
}
