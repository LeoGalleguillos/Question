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

    /**
     * @return int
     */
    public function insertSelectFromQuestion(
        string $modifiedReason,
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
                    , `created`
                    , `modified_reason`
                 )
            SELECT `question`.`question_id`
                 , `question`.`created_name`
                 , `question`.`subject`
                 , `question`.`message`
                 , IFNULL(
                       `question`.`modified_datetime`
                     , `question`.`created_datetime`
                   )
                 , ?
              FROM `question`
             WHERE `question`.`question_id` = ?
                 ;
        ';
        $parameters = [
            $modifiedReason,
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
        $sql = '
            SELECT `question_history`.`question_id`
                 , `question_history`.`name`
                 , `question_history`.`subject`
                 , `question_history`.`message`
                 , `question_history`.`modified_reason`
                 , `question_history`.`created`
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
}
