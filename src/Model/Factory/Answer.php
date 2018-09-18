<?php
namespace LeoGalleguillos\Question\Model\Factory;

use DateTime;
use LeoGalleguillos\Question\Model\Entity as QuestionEntity;
use LeoGalleguillos\Question\Model\Table as QuestionTable;
use TypeError;

class Answer
{
    /**
     * Construct
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
                     ->setMessage($array['message'])
                     ->setQuestionId($array['question_id']);

        if (isset($array['deleted'])) {
            $answerEntity->setDeleted(new DateTime($array['deleted']));
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

        try {
            $array = $this->answerHistoryTable->selectWhereAnswerIdOrderByCreatedAscLimit1(
                $answerId
            );
            $history = [
                0 => $this->buildFromArray($array),
            ];
            $answerEntity->setHistory($history);
        } catch (TypeError $typeError) {
            // Do nothing.
        }

        return $answerEntity;
    }
}
