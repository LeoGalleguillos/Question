<?php
namespace LeoGalleguillos\Question\Model\Table\Answer;

use Generator;
use LeoGalleguillos\Question\Model\Table as QuestionTable;
use Laminas\Db\Adapter\Adapter;

class DeletedDatetime
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

    public function selectWhereDeletedDatetimeIsNotNull(
        int $limitRowCount
    ): Generator {
        $sql = $this->answerTable->getSelect()
             . "
              FROM `answer`
             WHERE `answer`.`deleted_datetime` IS NOT NULL
             ORDER
                BY `answer`.`deleted_datetime` DESC
             LIMIT $limitRowCount
                 ;
        ";
        foreach ($this->adapter->query($sql)->execute() as $array) {
            yield $array;
        }
    }
}
