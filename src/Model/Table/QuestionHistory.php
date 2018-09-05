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
        string $note,
        int $questionMetaHistoryId = null,
        int $questionId
    ): int {
        $sql = '
            INSERT
              INTO `question_history`
                   (`question_id`, `user_id`, `subject`, `message`, `ip`, `created`
                    , `note`, `question_meta_history_id`)
            SELECT `question`.`question_id`
                 , `question`.`user_id`
                 , `question`.`subject`
                 , `question`.`message`
                 , `question`.`ip`
                 , `question`.`created`
                 , ? #note
                 , ? #questionMetaHistoryId
              FROM `question`
             WHERE `question`.`question_id` = ?
                 ;
        ';
        $parameters = [
            $note,
            $questionMetaHistoryId,
            $questionId,
        ];
        return $this->adapter
                    ->query($sql)
                    ->execute($parameters)
                    ->getGeneratedValue();
    }
}
