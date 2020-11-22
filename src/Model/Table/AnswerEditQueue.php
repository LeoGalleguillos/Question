<?php
namespace LeoGalleguillos\Question\Model\Table;

use Generator;
use Laminas\Db\Adapter\Adapter;

class AnswerEditQueue
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
        int $questionId,
        int $userId,
        string $name = null,
        string $message,
        string $ip,
        string $reason
    ): int {
        $sql = '
            INSERT
              INTO `answer_edit_queue`
                 (
                      `answer_id`
                    , `question_id`
                    , `user_id`
                    , `name`
                    , `message`
                    , `ip`
                    , `created_datetime`
                    , `reason`
                 )
            VALUES (?, ?, ?, ?, ?, ?, UTC_TIMESTAMP(), ?)
                 ;
        ';
        $parameters = [
            $answerId,
            $questionId,
            $userId,
            $name,
            $message,
            $ip,
            $reason
        ];
        return $this->adapter
                    ->query($sql)
                    ->execute($parameters)
                    ->getGeneratedValue();
    }

    public function selectWhereAnswerEditQueueId(
        int $answerEditQueueId
    ): array {
        $sql = '
            SELECT `answer_edit_queue_id`
                 , `answer_id`
                 , `question_id`
                 , `user_id`
                 , `name`
                 , `message`
                 , `ip`
                 , `created_datetime`
                 , `reason`
                 , `queue_status_id`
                 , `modified`
              FROM `answer_edit_queue`
             WHERE `answer_edit_queue_id` = ?
                 ;
        ';
        $parameters = [
            $answerEditQueueId,
        ];
        return $this->adapter->query($sql)->execute($parameters)->current();
    }

    public function selectWhereQueueStatusId(
        int $queueStatusId
    ): Generator {
        $sql = '
            SELECT `answer_edit_queue_id`
                 , `answer_id`
                 , `question_id`
                 , `user_id`
                 , `name`
                 , `message`
                 , `ip`
                 , `created_datetime`
                 , `reason`
                 , `queue_status_id`
                 , `modified`
              FROM `answer_edit_queue`
             WHERE `queue_status_id` = ?
             ORDER
                BY `created_datetime` ASC
                 ;
        ';
        $parameters = [
            $queueStatusId,
        ];
        foreach ($this->adapter->query($sql)->execute($parameters) as $array) {
            yield $array;
        }
    }

    public function updateSetQueueStatusIdWhereAnswerEditQueueId(
        int $queueStatusId,
        int $answerEditQueueId
    ): bool {
        $sql = '
            UPDATE `answer_edit_queue`
               SET `answer_edit_queue`.`queue_status_id` = ?
             WHERE `answer_edit_queue`.`answer_edit_queue_id` = ?
                 ;
        ';
        $parameters = [
            $queueStatusId,
            $answerEditQueueId,
        ];
        return (bool) $this->adapter
                           ->query($sql)
                           ->execute($parameters)
                           ->getAffectedRows();
    }
}
