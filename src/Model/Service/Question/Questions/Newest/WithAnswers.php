<?php
namespace LeoGalleguillos\Question\Model\Service\Question\Questions\Newest;

use Generator;
use LeoGalleguillos\Question\Model\Entity as QuestionEntity;
use LeoGalleguillos\Question\Model\Factory as QuestionFactory;
use LeoGalleguillos\Question\Model\Service as QuestionService;
use LeoGalleguillos\Question\Model\Table as QuestionTable;

class WithAnswers
{
    public function __construct(
        QuestionFactory\Answer $answerFactory,
        QuestionService\Questions $questionsService,
        QuestionTable\Answer $answerTable
    ) {
        $this->answerFactory    = $answerFactory;
        $this->questionsService = $questionsService;
        $this->answerTable      = $answerTable;
    }

    /**
     * Get questions with answers.
     *
     * @param int $page
     * @return Generator
     * @yield QuestionEntity\Question
     */
    public function getQuestionsWithAnswers(
        int $page
    ): Generator {
        $questionEntities = $this->questionsService->getQuestions(
            $page,
            50
        );

        foreach ($questionEntities as $questionEntity) {
            $answerEntities = [];
            $answerArrays = $this->answerTable
                ->selectWhereQuestionIdAndDeletedIsNullOrderByCreatedDateTimeAsc(
                    $questionEntity->getQuestionId()
                );
            foreach ($answerArrays as $answerArray) {
                $answerEntities[] = $this->answerFactory->buildFromArray($answerArray);
            }
            $questionEntity->setAnswers($answerEntities);

            yield $questionEntity;
        }

    }
}
