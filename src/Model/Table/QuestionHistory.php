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
    public function insert(
        int $questionId,
        int $userId = null,
        string $subject,
        string $message,
        string $ip,
        string $note = null,
        string $created,
        int $questionMetaHistoryId = null
    ): int {
        $sql = '
            INSERT
              INTO `question_history` (
                       `question_id`
                     , `user_id`
                     , `subject`
                     , `message`
                     , `ip`
                     , `note`
                     , `created`
                     , `question_meta_history_id`
                   )
            VALUES (?, ?, ?, ?, ?, ?, ?)
                 ;
        ';
        $parameters = [
            $questionId,
            $userId,
            $subject,
            $message,
            $ip,
            $note,
            $created,
            $questionMetaHistoryId,
        ];
        return $this->adapter
                    ->query($sql)
                    ->execute($parameters)
                    ->getGeneratedValue();
    }
}
