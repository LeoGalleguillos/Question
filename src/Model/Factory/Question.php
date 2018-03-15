<?php
namespace LeoGalleguillos\Question\Model\Factory;

use DateTime;
use LeoGalleguillos\Question\Model\Entity as QuestionEntity;
use LeoGalleguillos\Question\Model\Table as QuestionTable;

class Question
{
    /**
     * Construct
     *
     * @param QuestionTable\Question $questionTable
     */
    public function __construct(
        QuestionTable\Question $questionTable
    ) {
        $this->questionTable = $questionTable;
    }

    /**
     * Build from array.
     *
     * @param array $array
     * @return QuestionEntity\Question
     */
    public function buildFromArray(
        array $array
    ) : QuestionEntity\Question {
        $questionEntity = new QuestionEntity\Question();
        $questionEntity->setCreated(new DateTime($array['created']))
                       ->setMessage($array['message'])
                       ->setQuestionId($array['question_id'])
                       ->setSubject($array['subject'])
                       ->setViews($array['views']);

        return $questionEntity;
    }

    /**
     * Build from question ID.
     *
     * @param int $questionId
     * @return QuestionEntity\Question
     */
    public function buildFromQuestionId(
        int $questionId
    ) : QuestionEntity\Question {
        return $this->buildFromArray(
            $this->questionTable->selectWhereQuestionId($questionId)
        );
    }
}
