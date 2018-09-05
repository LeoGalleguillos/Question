<?php
namespace LeoGalleguillos\Question\Model\Factory;

use DateTime;
use Exception;
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
                       ->setQuestionId($array['question_id'])
                       ->setSubject($array['subject'])
                       ->setViews($array['views']);

        if (!empty($array['message'])) {
            $questionEntity->setMessage($array['message']);
        }

        return $questionEntity;
    }

    public function buildFromArrays(
        array $array,
        array $meta
    ) {
        return $this->buildFromArray($array)->setMeta($meta);
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
        $questionArray = $this->questionTable->selectWhereQuestionId(
            $questionId
        );

        try {
            $metaArray = $this->questionMetaTable->selectWhereQuestionId(
                $questionId
            );
        } catch (Exception $exception) {
            return $this->buildFromArray($questionArray);
        }

        return $this->buildFromArrays(
            $questionArray,
            $metaArray
        );
    }
}
