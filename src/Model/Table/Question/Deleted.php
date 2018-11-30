<?php
namespace LeoGalleguillos\Question\Model\Table\Question;

use Generator;
use LeoGalleguillos\Question\Model\Table as QuestionTable;
use Zend\Db\Adapter\Adapter;

class Deleted
{
    /**
     * @var Adapter
     */
    protected $adapter;

    public function __construct(
        Adapter $adapter,
        QuestionTable\Question $questionTable
    ) {
        $this->adapter       = $adapter;
        $this->questionTable = $questionTable;
    }

    public function selectWhereDeletedIsNotNull(
        int $limitRowCount
    ): Generator {
        $sql = $this->questionTable->getSelect()
             . "
              FROM `question`
             WHERE `question`.`deleted` IS NOT NULL
             ORDER
                BY `question`.`created_datetime` DESC
             LIMIT $limitRowCount
                 ;
        ";
        foreach ($this->adapter->query($sql)->execute() as $array) {
            yield $array;
        }
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
