<?php
namespace LeoGalleguillos\Question\Model\Service\Question;

use Exception;
use LeoGalleguillos\Question\Model\Entity as QuestionEntity;
use LeoGalleguillos\Question\Model\Table as QuestionTable;
use TypeError;
use Zend\Db\Adapter\Adapter;

class Edit
{
    public function __construct(
        Adapter $adapter,
        QuestionTable\Question $questionTable,
        QuestionTable\QuestionHistory $questionHistoryTable
    ) {
        $this->adapter              = $adapter;
        $this->questionTable        = $questionTable;
        $this->questionHistoryTable = $questionHistoryTable;
    }

    /**
     * @throws Exception
     */
    public function edit(
        QuestionEntity\Question $questionEntity,
        $name,
        $subject,
        $message,
        $modifiedUserId,
        $modifiedReason
    ) {
        try {
            $questionEntity->getCreatedUserId();
        } catch (TypeError $typeError) {
            if (empty($name)) {
                throw new Exception('Name cannot be empty');
            }
        }

        $this->adapter->getDriver()->getConnection()->beginTransaction();
        $this->questionHistoryTable->insertSelectFromQuestion(
            $questionEntity->getQuestionId()
        );
        $this->questionTable->updateWhereQuestionId(
            $subject,
            $message,
            $modifiedUserId,
            $modifiedReason,
            $questionEntity->getQuestionId()
        );
        $this->adapter->getDriver()->getConnection()->commit();
    }
}
