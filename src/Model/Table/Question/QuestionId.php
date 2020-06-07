<?php
namespace LeoGalleguillos\Question\Model\Table\Question;

use Laminas\Db\Adapter\Adapter;
use Laminas\Db\Adapter\Driver\Pdo\Result;
use LeoGalleguillos\Question\Model\Table as QuestionTable;

class QuestionId
{
    /**
     * @var Adapter
     */
    protected $adapter;

    public function __construct(
        Adapter $adapter,
        QuestionTable\Question $questionTable
    ) {
        $this->adapter       = $adapter;
        $this->questionTable = $questionTable;
    }

    public function selectWhereQuestionId(int $questionId): Result
    {
        $sql = $this->questionTable->getSelect()
            . '
              FROM `question`
             WHERE `question`.`question_id` = ?
                 ;
        ';
        $parameters = [
            $questionId,
        ];
        return $this->adapter->query($sql)->execute($parameters);
    }

    public function updateIncrementViewsBrowserWhereQuestionId(
        int $questionId
    ): int {
        $sql = '
            UPDATE `question`
               SET `question`.`views_browser` = `question`.`views_browser` + 1
             WHERE `question`.`question_id` = ?
                 ;
        ';
        $parameters = [
            $questionId,
        ];
        return (int) $this->adapter
            ->query($sql)
            ->execute($parameters)
            ->getAffectedRows();
    }

    public function updateSetCreatedNameWhereQuestionId(
        string $createdName,
        int $questionId
    ): int {
        $sql = '
            UPDATE `question`
               SET `question`.`created_name` = ?
             WHERE `question`.`question_id` = ?
                 ;
        ';
        $parameters = [
            $createdName,
            $questionId,
        ];
        return (int) $this->adapter
            ->query($sql)
            ->execute($parameters)
            ->getAffectedRows();
    }

    public function updateSetDeletedColumnsWhereQuestionId(
        int $deletedUserId,
        string $deletedReason,
        int $questionId
    ): int {
        $sql = '
            UPDATE `question`
               SET `question`.`deleted_datetime` = UTC_TIMESTAMP()
                 , `question`.`deleted_user_id` = ?
                 , `question`.`deleted_reason` = ?
             WHERE `question`.`question_id` = ?
                 ;
        ';
        $parameters = [
            $deletedUserId,
            $deletedReason,
            $questionId,
        ];
        return (int) $this->adapter
            ->query($sql)
            ->execute($parameters)
            ->getAffectedRows();
    }

    public function updateSetDeletedColumnsToNullWhereQuestionId(
        int $questionId
    ): int {
        $sql = '
            UPDATE `question`
               SET `question`.`deleted_datetime` = NULL
                 , `question`.`deleted_user_id` = NULL
                 , `question`.`deleted_reason` = NULL
             WHERE `question`.`question_id` = ?
                 ;
        ';
        $parameters = [
            $questionId,
        ];
        return (int) $this->adapter
            ->query($sql)
            ->execute($parameters)
            ->getAffectedRows();
    }

    public function updateSetModifiedReasonWhereQuestionId(
        string $modifiedReason,
        int $questionId
    ): Result {
        $sql = '
            UPDATE `question`
               SET `question`.`modified_reason` = ?
             WHERE `question`.`question_id` = ?
                 ;
        ';
        $parameters = [
            $modifiedReason,
            $questionId,
        ];
        return $this->adapter->query($sql)->execute($parameters);
    }
}
