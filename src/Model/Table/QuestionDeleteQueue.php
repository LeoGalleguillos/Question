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
