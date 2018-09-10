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

    /**
     * @return int
     */
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
                    , `ip`
                    , `created`
                    , `reason`
                 )
            SELECT `answer`.`answer_id`
                 , `answer`.`user_id`
                 , `answer`.`name`
                 , `answer`.`message`
                 , `answer`.`ip`
                 , `answer`.`created`
                 , ?
              FROM `answer`
             WHERE `answer`.`answer_id` = ?
                 ;
        ';
        $parameters = [
            $reason,
            $answerId,
        ];
        return $this->adapter
                    ->query($sql)
                    ->execute($parameters)
                    ->getGeneratedValue();
    }
}
