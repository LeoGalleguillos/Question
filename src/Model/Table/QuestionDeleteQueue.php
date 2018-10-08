<?php
namespace LeoGalleguillos\Question\Model\Table;

use Generator;
use Zend\Db\Adapter\Adapter;

class QuestionDeleteQueue
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
        string $reason
    ): int {
        $sql = '
            INSERT
              INTO `question_delete_queue`
                 (
                      `question_id`
                    , `user_id`
                    , `reason`
                    , `created`
                 )
            VALUES (?, ?, ?, UTC_TIMESTAMP())
                 ;
        ';
        $parameters = [
            $questionId,
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
            SELECT `question_delete_queue_id`
                 , `question_id`
                 , `user_id`
                 , `reason`
                 , `created`
                 , `queue_status_id`
                 , `modified`
              FROM `question_delete_queue`
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

    public function updateSetQueueStatusIdWhereQuestionDeleteQueueId(
        int $queueStatusId,
        int $questionDeleteQueueId
    ): bool {
        $sql = '
            UPDATE `question_delete_queue`
               SET `question_delete_queue`.`queue_status_id` = ?
             WHERE `question_delete_queue`.`question_delete_queue_id` = ?
                 ;
        ';
        $parameters = [
            $queueStatusId,
            $questionDeleteQueueId,
        ];
        return (bool) $this->adapter
                           ->query($sql)
                           ->execute($parameters)
                           ->getAffectedRows();
    }
}
