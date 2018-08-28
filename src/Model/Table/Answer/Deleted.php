<?php
namespace LeoGalleguillos\Question\Model\Table\Answer;

use Zend\Db\Adapter\Adapter;

class Deleted
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
    public function updateSetToUtcTimestampWhereAnswerId(
        int $answerId
    ): bool {
        $sql = '
            UPDATE `answer`
               SET `answer`.`deleted` = UTC_TIMESTAMP()
             WHERE `answer`.`answer_id` = ?
                 ;
        ';
        $parameters = [
            $answerId,
        ];
        return (bool) $this->adapter
                           ->query($sql)
                           ->execute($parameters)
                           ->getAffectedRows();
    }
}
