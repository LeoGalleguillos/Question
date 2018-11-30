<?php
namespace LeoGalleguillos\Question\Model\Table\Question;

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
    public function updateWhereQuestionId(
        int $deletedUserId,
        string $deletedReason,
        int $questionId
    ): bool {
        $sql = '
            UPDATE `question`
               SET `question`.`deleted` = UTC_TIMESTAMP()
                 , `question`.`deleted_user_id` = ?
                 , `question`.`deleted_reason` = ?
             WHERE `question`.`question_id` = ?
                 ;
        ';
        $parameters = [
            $deletedUserId,
            $deletedReason,
            $questionId,
        ];
        return (bool) $this->adapter
                           ->query($sql)
                           ->execute($parameters)
                           ->getAffectedRows();
    }

    public function updateSetDeletedDeletedUserIdDeletedReasonWhereQuestionId(
        string $deleted,
        int $deletedUserId,
        string $deletedReason,
        int $questionId
    ): bool {
        $sql = '
            UPDATE `question`
               SET `question`.`deleted` = ?
                 , `question`.`deleted_user_id` = ?
                 , `question`.`deleted_reason` = ?
             WHERE `question`.`question_id` = ?
                 ;
        ';
        $parameters = [
            $deleted,
            $deletedUserId,
            $deletedReason,
            $questionId,
        ];
        return (bool) $this->adapter
                           ->query($sql)
                           ->execute($parameters)
                           ->getAffectedRows();
    }

    public function updateToNullWhereQuestionId(
        int $questionId
    ): int {
        $sql = '
            UPDATE `question`
               SET `question`.`deleted` = NULL
                 , `question`.`deleted_user_id` = NULL
                 , `question`.`deleted_reason` = NULL
             WHERE `question`.`question_id` = ?
                 ;
        ';
        $parameters = [
            $questionId,
        ];
        return (int) $this->adapter
                          ->query($sql)
                          ->execute($parameters)
                          ->getAffectedRows();
    }
}
