<?php
namespace LeoGalleguillos\Question\Model\Table;

use Generator;
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

    public function selectWhereQuestionEditQueueId(
        int $questionEditQueueId
    ): array {
        $sql = '
            SELECT `question_edit_queue_id`
                 , `question_id`
                 , `user_id`
                 , `name`
                 , `subject`
                 , `message`
                 , `ip`
                 , `created`
                 , `reason`
                 , `queue_status_id`
                 , `modified`
              FROM `question_edit_queue`
             WHERE `question_edit_queue_id` = ?
                 ;
        ';
        $parameters = [
            $questionEditQueueId,
        ];
        return $this->adapter->query($sql)->execute($parameters)->current();
    }

    public function selectWhereQueueStatusId(
        int $queueStatusId
    ): Generator {
        $sql = '
            SELECT `question_edit_queue_id`
                 , `question_id`
                 , `user_id`
                 , `name`
                 , `subject`
                 , `message`
                 , `ip`
                 , `created`
                 , `reason`
                 , `queue_status_id`
                 , `modified`
              FROM `question_edit_queue`
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

    public function updateSetQueueStatusIdWhereQuestionEditQueueId(
        int $queueStatusId,
        int $questionEditQueueId
    ): bool {
        $sql = '
            UPDATE `question_edit_queue`
               SET `question_edit_queue`.`queue_status_id` = ?
             WHERE `question_edit_queue`.`question_edit_queue_id` = ?
                 ;
        ';
        $parameters = [
            $queueStatusId,
            $questionEditQueueId
        ];
        return (bool) $this->adapter
                           ->query($sql)
                           ->execute($parameters)
                           ->getAffectedRows();
    }
}
