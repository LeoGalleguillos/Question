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

    public function selectWhereQueueStatusId(
        int $queueStatusId
    ): Generator {
        $sql = '
            SELECT `answer_delete_queue_id`
                 , `answer_id`
                 , `user_id`
                 , `reason`
                 , `created`
                 , `queue_status_id`
                 , `modified`
              FROM `answer_delete_queue`
             WHERE `queue_status_id` = ?
             ORDER
                BY `created` ASC
                 ;
        ';
        $parameters = [
            $queueStatusId,
        ];
        foreach ($this->adapter->query($sql)->execute($parameters) as $array) {
            yield $array;
        }
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
