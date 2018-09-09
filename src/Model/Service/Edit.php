<?php
namespace LeoGalleguillos\Question\Model\Service;

use LeoGalleguillos\Question\Model\Entity as QuestionEntity;
use LeoGalleguillos\Question\Model\Factory as QuestionFactory;
use LeoGalleguillos\Question\Model\Service as QuestionService;
use LeoGalleguillos\Question\Model\Table as QuestionTable;
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

    public function edit(
        QuestionEntity\Question $questionEntity,
        $userId,
        $name,
        $subject,
        $message,
        $ip,
        $reason
    ) {
        $this->adapter->getDriver()->getConnection()->beginTransaction();
        $questionHistoryId = $this->questionHistoryTable->insertSelectFromQuestion(
            $reason,
            $questionEntity->getQuestionId()
        );
        $this->questionTable->updateWhereQuestionId(
            $userId,
            $name,
            $subject,
            $message,
            $ip,
            $questionEntity->getQuestionId()
        );
        $this->adapter->getDriver()->getConnection()->commit();
    }
}
