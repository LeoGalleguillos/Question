<?php
namespace LeoGalleguillos\Question\Model\Table\Question;

use Zend\Db\Adapter\Adapter;

class Subject
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
        string $subject,
        int $questionId
    ): bool {
        $sql = '
            UPDATE `question`
               SET `question`.`subject` = ?
             WHERE `question`.`question_id` = ?
                 ;
        ';
        $parameters = [
            $subject,
            $questionId,
        ];
        return (bool) $this->adapter
                           ->query($sql)
                           ->execute($parameters)
                           ->getAffectedRows();
    }
}
