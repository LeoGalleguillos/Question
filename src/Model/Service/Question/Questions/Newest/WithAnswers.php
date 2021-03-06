<?php
namespace LeoGalleguillos\Question\Model\Service\Question\Questions\Newest;

use Generator;
use LeoGalleguillos\Question\Model\Factory as QuestionFactory;
use LeoGalleguillos\Question\Model\Service as QuestionService;
use LeoGalleguillos\Question\Model\Table as QuestionTable;

class WithAnswers
{
    public function __construct(
        QuestionFactory\Answer $answerFactory,
        QuestionService\Question\QuestionsInterface $questionsInterface,
        QuestionTable\Answer $answerTable
    ) {
        $this->answerFactory      = $answerFactory;
        $this->questionsInterface = $questionsInterface;
        $this->answerTable        = $answerTable;
    }

    public function getQuestionsWithAnswers(
        int $page
    ): Generator {
        $questionEntities = $this->questionsInterface->getQuestions(
            $page,
            50
        );

        foreach ($questionEntities as $questionEntity) {
            $answerEntities = [];
            $answerArrays = $this->answerTable
                ->selectWhereQuestionIdAndDeletedDatetimeIsNullOrderByCreatedDateTimeAsc(
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
