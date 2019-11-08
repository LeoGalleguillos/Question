<?php
namespace LeoGalleguillos\Question\Model\Table\Answer;

use Zend\Db\Adapter\Adapter;

class AnswerId
{
    /**
     * @var Adapter
     */
    protected $adapter;

    public function __construct(Adapter $adapter)
    {
        $this->adapter = $adapter;
    }

    public function updateSetDeletedColumnsWhereAnswerId(
        int $deletedUserId,
        string $deletedReason,
        int $answerId
    ): int {
        $sql = '
            UPDATE `answer`
               SET `answer`.`deleted` = UTC_TIMESTAMP()
                 , `answer`.`deleted_datetime` = UTC_TIMESTAMP()
                 , `answer`.`deleted_user_id` = ?
                 , `answer`.`deleted_reason` = ?
             WHERE `answer`.`answer_id` = ?
                 ;
        ';
        $parameters = [
            $deletedUserId,
            $deletedReason,
            $answerId,
        ];
        return (bool) $this->adapter
                           ->query($sql)
                           ->execute($parameters)
                           ->getAffectedRows();
    }

    public function updateSetDeletedColumnsToNullWhereAnswerId(
        int $answerId
    ): int {
        $sql = '
            UPDATE `answer`
               SET `answer`.`deleted` = NULL
                 , `answer`.`deleted_datetime` = NULL
                 , `answer`.`deleted_user_id` = NULL
                 , `answer`.`deleted_reason` = NULL
             WHERE `answer`.`answer_id` = ?
                 ;
        ';
        $parameters = [
            $answerId,
        ];
        return (int) $this->adapter
                          ->query($sql)
                          ->execute($parameters)
                          ->getAffectedRows();
    }

    public function updateSetCreatedNameWhereAnswerId(
        string $createdName,
        int $answerId
    ): int {
        $sql = '
            UPDATE `answer`
               SET `answer`.`created_name` = ?
             WHERE `answer`.`answer_id` = ?
                 ;
        ';
        $parameters = [
            $createdName,
            $answerId,
        ];
        return (int) $this->adapter
            ->query($sql)
            ->execute($parameters)
            ->getAffectedRows();
    }
}
