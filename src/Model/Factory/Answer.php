<?php
namespace LeoGalleguillos\Question\Model\Factory;

use DateTime;
use LeoGalleguillos\Question\Model\Entity as QuestionEntity;
use LeoGalleguillos\Question\Model\Table as QuestionTable;
use TypeError;

class Answer
{
    public function __construct(
        QuestionTable\Answer $answerTable
    ) {
        $this->answerTable = $answerTable;
    }

    public function buildFromArray(
        array $array
    ): QuestionEntity\Answer {
        $answerEntity = new QuestionEntity\Answer();
        $answerEntity->setAnswerId($array['answer_id'])
                     ->setCreatedDateTime(new DateTime($array['created_datetime']))
                     ->setMessage($array['message']);

        if (isset($array['created_ip'])) {
            $answerEntity->setCreatedIp($array['created_ip']);
        }
        if (isset($array['created_name'])) {
            $answerEntity->setCreatedName($array['created_name']);
        }
        if (isset($array['deleted_datetime'])) {
            $answerEntity->setDeletedDateTime(new DateTime($array['deleted_datetime']));
        }
        if (isset($array['deleted_user_id'])) {
            $answerEntity->setDeletedUserId($array['deleted_user_id']);
        }
        if (isset($array['deleted_reason'])) {
            $answerEntity->setDeletedReason($array['deleted_reason']);
        }
        if (isset($array['ip'])) {
            $answerEntity->setIp($array['ip']);
        }
        if (isset($array['question_id'])) {
            $answerEntity->setQuestionId($array['question_id']);
        }
        if (isset($array['user_id'])) {
            $answerEntity->setUserId($array['user_id']);
        }

        return $answerEntity;
    }

    public function buildFromAnswerId(
        int $answerId
    ): QuestionEntity\Answer {
        $answerEntity = $this->buildFromArray(
            $this->answerTable->selectWhereAnswerId($answerId)
        );

        return $answerEntity;
    }
}
