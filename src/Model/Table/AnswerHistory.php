<?php
namespace LeoGalleguillos\Question\Model\Table;

use Zend\Db\Adapter\Adapter;

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
        string $reason,
        int $answerId
    ): int {
        $sql = '
            INSERT
              INTO `answer_history`
                 (
                      `answer_id`
                    , `user_id`
                    , `name`
                    , `message`
                    , `created`
                    , `reason`
                 )
            SELECT `answer`.`answer_id`
                 , `answer`.`user_id`
                 , `answer`.`created_name`
                 , `answer`.`message`
                 , IFNULL(`answer`.`modified_datetime`, `answer`.`created_datetime`)
                 , ?
              FROM `answer`
             WHERE `answer`.`answer_id` = ?
                 ;
        ';
        $parameters = [
            $reason,
            $answerId,
        ];
        return (int) $this->adapter
            ->query($sql)
            ->execute($parameters)
            ->getGeneratedValue();
    }

    public function selectWhereAnswerIdOrderByCreatedAscLimit1(
        int $answerId
    ): array {
        $sql = '
            SELECT `answer_history`.`answer_id`
                 , `answer_history`.`user_id`
                 , `answer_history`.`name`
                 , `answer_history`.`message`
                 , `answer_history`.`created`
                 , `answer_history`.`reason`
              FROM `answer_history`
             WHERE `answer_history`.`answer_id` = ?
             ORDER
                BY `answer_history`.`created` ASC
             LIMIT 1
                 ;
        ';
        $parameters = [
            $answerId,
        ];
        return $this->adapter
                    ->query($sql)
                    ->execute($parameters)
                    ->current();
    }
}
