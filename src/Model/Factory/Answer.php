<?php
namespace LeoGalleguillos\Question\Model\Factory;

use DateTime;
use LeoGalleguillos\Question\Model\Entity as QuestionEntity;
use LeoGalleguillos\Question\Model\Table as QuestionTable;
use TypeError;

class Answer
{
    /**
     * Construct.
     *
     * @param QuestionTable\Question $answerTable
     */
    public function __construct(
        QuestionTable\Answer $answerTable
    ) {
        $this->answerTable = $answerTable;
    }

    /**
     * Build from array.
     *
     * @param array $array
     * @return QuestionEntity\Answer
     */
    public function buildFromArray(
        array $array
    ): QuestionEntity\Answer {
        $answerEntity = new QuestionEntity\Answer();
        $answerEntity->setAnswerId($array['answer_id'])
                     ->setCreated(new DateTime($array['created']))
                     ->setMessage($array['message']);

        if (isset($array['ip'])) {
            $answerEntity->setIp($array['ip']);
        }
        if (isset($array['created_datetime'])) {
            $answerEntity->setCreatedDateTime($array['created_datetime']);
        }
        if (isset($array['created_ip'])) {
            $answerEntity->setCreatedIp($array['created_ip']);
        }
        if (isset($array['created_name'])) {
            $answerEntity->setCreatedName($array['created_name']);
        }
        if (isset($array['deleted'])) {
            $answerEntity->setDeleted(new DateTime($array['deleted']));
        }
        if (isset($array['question_id'])) {
            $answerEntity->setQuestionId($array['question_id']);
        }

        return $answerEntity;
    }

    /**
     * Build from answer ID.
     *
     * @param int $answerId
     * @return QuestionEntity\Answer
     */
    public function buildFromAnswerId(
        int $answerId
    ): QuestionEntity\Answer {
        $answerEntity = $this->buildFromArray(
            $this->answerTable->selectWhereAnswerId($answerId)
        );

        return $answerEntity;
    }
}
