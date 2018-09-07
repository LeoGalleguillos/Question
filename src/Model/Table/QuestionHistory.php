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
                 , `question`.`name`
                 , `question`.`subject`
                 , `question`.`message`
                 , `question`.`ip`
                 , `question`.`created`
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
}
