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
        QuestionService\Questions $questionsService
    ) {
        $this->questionsService = $questionsService;
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
        $questionEntities = $this->questionsService->getQuestions($page);

        foreach ($questionEntities as $questionEntity) {
            $answerEntities = [];
            $answerArrays = $this->answerTable
                ->selectWhereQuestionIdAndDeletedIsNullOrderByCreatedDateTimeDesc(
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
