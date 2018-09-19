<?php
namespace LeoGalleguillos\Question\Model\Service;

use LeoGalleguillos\Question\Model\Entity as QuestionEntity;
use LeoGalleguillos\Question\Model\Factory as QuestionFactory;

class QuestionFromAnswer
{
    /**
     * Construct.
     *
     * @param QuestionFactory\Question $questionFactory
     */
    public function __construct(
        QuestionFactory\Question $questionFactory
    ) {
        $this->questionFactory = $questionFactory;
    }

    /**
     * Get quesstion from answer.
     *
     * @return QuestionEntity\Question
     */
    public function getQuestionFromAnswer(
        QuestionEntity\Answer $answerEntity
    ): QuestionEntity\Question {
        return $this->questionFactory->buildFromQuestionId(
            $answerEntity->getQuestionId()
        );
    }
}
