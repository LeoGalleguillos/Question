<?php
namespace LeoGalleguillos\Question\Model\Factory;

use DateTime;
use LeoGalleguillos\Question\Model\Entity as QuestionEntity;
use LeoGalleguillos\Question\Model\Table as QuestionTable;
use TypeError;

class Question
{
    /**
     * Construct.
     *
     * @param QuestionTable\Question $questionTable
     */
    public function __construct(
        QuestionTable\Question $questionTable,
        QuestionTable\QuestionHistory $questionHistoryTable
    ) {
        $this->questionTable        = $questionTable;
        $this->questionHistoryTable = $questionHistoryTable;
    }

    /**
     * Build from array.
     *
     * @param array $array
     * @return QuestionEntity\Question
     */
    public function buildFromArray(
        array $array
    ): QuestionEntity\Question {
        $questionEntity = new QuestionEntity\Question();
        $questionEntity->setCreated(new DateTime($array['created']))
                       ->setQuestionId($array['question_id'])
                       ->setSubject($array['subject']);

        if (isset($array['ip'])) {
            $questionEntity->setIp($array['ip']);
        }

        if (isset($array['message'])) {
            $questionEntity->setMessage($array['message']);
        }

        if (isset($array['name'])) {
            $questionEntity->setName($array['name']);
        }

        if (isset($array['views'])) {
            $questionEntity->setViews((int) $array['views']);
        }

        if (isset($array['deleted'])) {
            $questionEntity->setDeleted(new DateTime($array['deleted']));
        }

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
    ): QuestionEntity\Question {
        $questionEntity = $this->buildFromArray(
            $this->questionTable->selectWhereQuestionId($questionId)
        );

        try {
            $array = $this->questionHistoryTable->selectWhereQuestionIdOrderByCreatedAscLimit1(
                $questionId
            );
            $history = [
                0 => $this->buildFromArray($array),
            ];
            $questionEntity->setHistory($history);
        } catch (TypeError $typeError) {
            // Do nothing.
        }

        return $questionEntity;
    }
}
