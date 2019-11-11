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

    public function getAnswers(
        QuestionEntity\Question $questionEntity
    ) : Generator {
        $arrays = $this->answerTable->selectWhereQuestionIdAndDeletedDatetimeIsNullOrderByCreatedDateTimeAsc(
            $questionEntity->getQuestionId()
        );
        foreach ($arrays as $array) {
            yield $this->answerFactory->buildFromArray($array);
        }
    }
}
