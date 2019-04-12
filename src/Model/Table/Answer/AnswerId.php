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

    public function updateSetDeletedDeletedUserIdDeletedReasonToNullWhereAnswerId(
        int $answerId
    ): int {
        $sql = '
            UPDATE `answer`
               SET `answer`.`deleted` = NULL
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
