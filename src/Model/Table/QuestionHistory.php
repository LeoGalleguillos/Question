<?php
namespace LeoGalleguillos\Question\Model\Table;

use Zend\Db\Adapter\Adapter;

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
        string $reason,
        int $questionId
    ): int {
        $sql = '
            INSERT
              INTO `question_history`
                 (
                      `question_id`
                    , `user_id`
                    , `name`
                    , `subject`
                    , `message`
                    , `ip`
                    , `created`
                    , `reason`
                 )
            SELECT `question`.`question_id`
                 , `question`.`user_id`
                 , `question`.`created_name`
                 , `question`.`subject`
                 , `question`.`message`
                 , `question`.`ip`
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
            $reason,
            $questionId,
        ];
        return $this->adapter
                    ->query($sql)
                    ->execute($parameters)
                    ->getGeneratedValue();
    }

    public function selectWhereQuestionIdOrderByCreatedAscLimit1(
        int $questionId
    ): array {
        $sql = '
            SELECT `question_history`.`question_id`
                 , `question_history`.`user_id`
                 , `question_history`.`name`
                 , `question_history`.`subject`
                 , `question_history`.`message`
                 , `question_history`.`ip`
                 , `question_history`.`created`
                 , `question_history`.`reason`
              FROM `question_history`
             WHERE `question_history`.`question_id` = ?
             ORDER
                BY `question_history`.`created` ASC
             LIMIT 1
                 ;
        ';
        $parameters = [
            $questionId,
        ];
        return $this->adapter
                    ->query($sql)
                    ->execute($parameters)
                    ->current();
    }
}
