<?php
namespace LeoGalleguillos\Question\Model\Service\Answer;

use LeoGalleguillos\Question\Model\Entity as QuestionEntity;
use LeoGalleguillos\Question\Model\Table as QuestionTable;
use Zend\Db\Adapter\Adapter;

class Edit
{
    public function __construct(
        Adapter $adapter,
        QuestionTable\Answer $answerTable,
        QuestionTable\AnswerHistory $answerHistoryTable
    ) {
        $this->adapter            = $adapter;
        $this->answerTable        = $answerTable;
        $this->answerHistoryTable = $answerHistoryTable;
    }

    public function edit(
        QuestionEntity\Answer $answerEntity,
        $name,
        $message,
        $modifiedUserId,
        $modifiedReason
    ) {
        $this->adapter->getDriver()->getConnection()->beginTransaction();
        $this->answerHistoryTable->insertSelectFromAnswer(
            $answerEntity->getAnswerId()
        );
        $this->answerTable->updateWhereAnswerId(
            $name,
            $message,
            $modifiedUserId,
            $modifiedReason,
            $answerEntity->getAnswerId()
        );
        $this->adapter->getDriver()->getConnection()->commit();
    }
}
