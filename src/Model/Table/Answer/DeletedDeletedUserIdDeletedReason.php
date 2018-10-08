<?php
namespace LeoGalleguillos\Question\Model\Table\Answer;

use Zend\Db\Adapter\Adapter;

class DeletedDeletedUserIdDeletedReason
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
     * @return bool
     */
    public function updateWhereAnswerId(
        int $deletedUserId,
        string $deletedReason,
        int $answerId
    ): bool {
        $sql = '
            UPDATE `answer`
               SET `answer`.`deleted` = UTC_TIMESTAMP()
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

    public function updateSetDeletedDeletedUserIdDeletedReasonWhereAnswerId(
        string $deleted,
        int $deletedUserId,
        string $deletedReason,
        int $answerId
    ): bool {
        $sql = '
            UPDATE `answer`
               SET `answer`.`deleted` = ?
                 , `answer`.`deleted_user_id` = ?
                 , `answer`.`deleted_reason` = ?
             WHERE `answer`.`answer_id` = ?
                 ;
        ';
        $parameters = [
            $deleted,
            $deletedUserId,
            $deletedReason,
            $answerId,
        ];
        return (bool) $this->adapter
                           ->query($sql)
                           ->execute($parameters)
                           ->getAffectedRows();
    }
}
