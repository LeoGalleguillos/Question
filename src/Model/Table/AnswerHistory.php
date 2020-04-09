<?php
namespace LeoGalleguillos\Question\Model\Table;

use Laminas\Db\Adapter\Adapter;
use Laminas\Db\Adapter\Driver\Pdo\Result;

class AnswerHistory
{
    /**
     * @var Adapter
     */
    protected $adapter;

    public function __construct(Adapter $adapter)
    {
        $this->adapter = $adapter;
    }

    public function insertSelectFromAnswer(
        string $modifiedReason,
        int $answerId
    ): int {
        $sql = '
            INSERT
              INTO `answer_history`
                 (
                      `answer_id`
                    , `name`
                    , `message`
                    , `created`
                    , `modified_reason`
                 )
            SELECT `answer`.`answer_id`
                 , `answer`.`created_name`
                 , `answer`.`message`
                 , IFNULL(`answer`.`modified_datetime`, `answer`.`created_datetime`)
                 , ?
              FROM `answer`
             WHERE `answer`.`answer_id` = ?
                 ;
        ';
        $parameters = [
            $modifiedReason,
            $answerId,
        ];
        return (int) $this->adapter
            ->query($sql)
            ->execute($parameters)
            ->getGeneratedValue();
    }

    public function selectDistinctAnswerId(): Result
    {
        $sql = '
            SELECT
          DISTINCT `answer_id`
              FROM `answer_history`
             ORDER
                BY `answer_id` ASC
                 ;
        ';
        return $this->adapter->query($sql)->execute();
    }

    public function selectWhereAnswerIdOrderByCreatedDesc(
        int $answerId
    ): Result {
        $sql = '
            SELECT `answer_history`.`answer_history_id`
                 , `answer_history`.`answer_id`
                 , `answer_history`.`name`
                 , `answer_history`.`message`
                 , `answer_history`.`modified_reason`
                 , `answer_history`.`created`
              FROM `answer_history`
             WHERE `answer_history`.`answer_id` = ?
             ORDER
                BY `answer_history`.`created` DESC
                 , `answer_history`.`answer_id` DESC
                 ;
        ';
        $parameters = [
            $answerId,
        ];
        return $this->adapter->query($sql)->execute($parameters);
    }
}
