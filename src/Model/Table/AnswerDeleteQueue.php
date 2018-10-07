<?php
namespace LeoGalleguillos\Question\Model\Table;

use Generator;
use Zend\Db\Adapter\Adapter;

class AnswerDeleteQueue
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
        int $answerId,
        int $userId,
        string $reason
    ): int {
        $sql = '
            INSERT
              INTO `answer_delete_queue`
                 (
                      `answer_id`
                    , `user_id`
                    , `reason`
                    , `created`
                 )
            VALUES (?, ?, ?, UTC_TIMESTAMP())
                 ;
        ';
        $parameters = [
            $answerId,
            $userId,
            $reason
        ];
        return $this->adapter
                    ->query($sql)
                    ->execute($parameters)
                    ->getGeneratedValue();
    }

    public function updateSetQueueStatusIdWhereAnswerDeleteQueueId(
        int $queueStatusId,
        int $answerDeleteQueueId
    ): bool {
        $sql = '
            UPDATE `answer_delete_queue`
               SET `answer_delete_queue`.`queue_status_id` = ?
             WHERE `answer_delete_queue`.`answer_delete_queue_id` = ?
                 ;
        ';
        $parameters = [
            $queueStatusId,
            $answerDeleteQueueId,
        ];
        return (bool) $this->adapter
                           ->query($sql)
                           ->execute($parameters)
                           ->getAffectedRows();
    }
}
