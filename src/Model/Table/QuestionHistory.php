<?php
namespace LeoGalleguillos\Question\Model\Table;

use Laminas\Db\Adapter\Adapter;
use Laminas\Db\Adapter\Driver\Pdo\Result;

class QuestionHistory
{
    /**
     * @var Adapter
     */
    protected $adapter;

    public function __construct(Adapter $adapter)
    {
        $this->adapter = $adapter;
    }

    public function getSelect(): string
    {
        return '
            SELECT `question_history`.`question_history_id`
                 , `question_history`.`question_id`
                 , `question_history`.`name`
                 , `question_history`.`subject`
                 , `question_history`.`message`
                 , `question_history`.`modified_reason`
                 , `question_history`.`created`
        ';
    }

    /**
     * @return int
     */
    public function insertSelectFromQuestion(
        int $questionId
    ): int {
        $sql = '
            INSERT
              INTO `question_history`
                 (
                      `question_id`
                    , `name`
                    , `subject`
                    , `message`
                    , `modified_reason`
                    , `created`
                 )
            SELECT `question`.`question_id`
                 , `question`.`created_name`
                 , `question`.`subject`
                 , `question`.`message`
                 , `question`.`modified_reason`
                 , UTC_TIMESTAMP()
              FROM `question`
             WHERE `question`.`question_id` = ?
                 ;
        ';
        $parameters = [
            $questionId,
        ];
        return $this->adapter
                    ->query($sql)
                    ->execute($parameters)
                    ->getGeneratedValue();
    }

    public function selectDistinctQuestionId(): Result
    {
        $sql = '
            SELECT
          DISTINCT `question_id`
              FROM `question_history`
             ORDER
                BY `question_id` ASC
                 ;
        ';
        return $this->adapter->query($sql)->execute();
    }

    public function selectWhereQuestionIdOrderByCreatedAsc(
        int $questionId
    ): Result {
        $sql = $this->getSelect()
            . '
              FROM `question_history`
             WHERE `question_history`.`question_id` = ?
             ORDER
                BY `question_history`.`created` ASC
                 , `question_history`.`question_id` ASC
                 ;
        ';
        $parameters = [
            $questionId,
        ];
        return $this->adapter->query($sql)->execute($parameters);
    }

    public function selectWhereQuestionIdOrderByCreatedDesc(
        int $questionId
    ): Result {
        $sql = $this->getSelect()
            . '
              FROM `question_history`
             WHERE `question_history`.`question_id` = ?
             ORDER
                BY `question_history`.`created` DESC
                 , `question_history`.`question_id` DESC
                 ;
        ';
        $parameters = [
            $questionId,
        ];
        return $this->adapter->query($sql)->execute($parameters);
    }

    public function updateSetCreatedWhereQuestionHistoryId(
        string $created,
        int $questionHistoryId
    ): Result {
        $sql = '
            UPDATE `question_history`
               SET `created` = ?
             WHERE `question_history_id` = ?
                 ;
        ';
        $parameters = [
            $created,
            $questionHistoryId,
        ];
        return $this->adapter->query($sql)->execute($parameters);
    }

    public function updateSetModifiedReasonWhereQuestionHistoryId(
        string $modifiedReason = null,
        int $questionHistoryId
    ): Result {
        $sql = '
            UPDATE `question_history`
               SET `modified_reason` = ?
             WHERE `question_history_id` = ?
                 ;
        ';
        $parameters = [
            $modifiedReason,
            $questionHistoryId,
        ];
        return $this->adapter->query($sql)->execute($parameters);
    }
}
