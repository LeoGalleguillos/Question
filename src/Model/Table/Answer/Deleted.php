<?php
namespace LeoGalleguillos\Question\Model\Table\Answer;

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
        QuestionTable\Answer $answerTable
    )
    {
        $this->adapter     = $adapter;
        $this->answerTable = $answerTable;
    }

    public function selectWhereDeletedIsNotNull(
        int $limitRowCount
    ): Generator {
        $sql = $this->answerTable->getSelect()
             . "
              FROM `answer`
             WHERE `answer`.`deleted` IS NOT NULL
             ORDER
                BY `answer`.`created_datetime` DESC
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
