<?php
namespace LeoGalleguillos\Question\Model\Table\Question;

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
    public function updateSetToUtcTimestampWhereQuestionId(
        int $questionId
    ): bool {
        $sql = '
            UPDATE `question`
               SET `question`.`deleted` = UTC_TIMESTAMP()
             WHERE `question`.`question_id` = ?
                 ;
        ';
        $parameters = [
            $questionId,
        ];
        return (bool) $this->adapter
                           ->query($sql)
                           ->execute($parameters)
                           ->getAffectedRows();
    }
}
