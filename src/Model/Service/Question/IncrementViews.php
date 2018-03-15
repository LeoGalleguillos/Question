<?php
namespace LeoGalleguillos\Question\Model\Service\Question;

use LeoGalleguillos\Question\Model\Entity as QuestionEntity;
use LeoGalleguillos\Question\Model\Table as QuestionTable;

class IncrementViews
{
    /**
     * Construct.
     *
     * @param QuestionTable\Question $questionTable
     */
    public function __construct(
        QuestionTable\Question $questionTable
    ) {
        $this->questionTable = $questionTable;
    }

    /**
     * Increment views.
     *
     * @param QuestionEntity\Question $questionEntity
     * @return bool
     */
    public function incrementViews(QuestionEntity\Question $questionEntity)
    {
        return $this->questionTable->updateViewsWhereQuestionId(
            $questionEntity->getQuestionId()
        );
    }
}
