<?php
namespace LeoGalleguillos\Question\Model\Table;

use Zend\Db\Adapter\Adapter;

class QuestionEditQueue
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
        int $userId,
        string $name = null,
        string $subject,
        string $message,
        string $ip,
        string $reason
    ): int {
        $sql = '
            INSERT
              INTO `question_edit_queue`
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
            VALUES (?, ?, ?, ?, ?, ?, UTC_TIMESTAMP(), ?)
                 ;
        ';
        $parameters = [
            $questionId,
            $userId,
            $name,
            $subject,
            $message,
            $ip,
            $reason
        ];
        return $this->adapter
                    ->query($sql)
                    ->execute($parameters)
                    ->getGeneratedValue();
    }
}
