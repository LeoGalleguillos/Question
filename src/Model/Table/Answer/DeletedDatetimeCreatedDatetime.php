<?php
namespace LeoGalleguillos\Question\Model\Table\Answer;

use Generator;
use LeoGalleguillos\Question\Model\Table as QuestionTable;
use Laminas\Db\Adapter\Adapter;

class DeletedDatetimeCreatedDatetime
{
    /**
     * @var Adapter
     */
    protected $adapter;

    public function __construct(
        Adapter $adapter,
        QuestionTable\Answer $answerTable
    ) {
        $this->adapter     = $adapter;
        $this->answerTable = $answerTable;
    }

    public function selectWhereDeletedDatetimeIsNullOrderByCreatedDatetimeDesc(): Generator {
        $sql = $this->answerTable->getSelect()
             . '
              FROM `answer`
             WHERE `answer`.`deleted_datetime` IS NULL
             ORDER
                BY `answer`.`created_datetime` DESC
             LIMIT 100
                 ;
        ';
        foreach ($this->adapter->query($sql)->execute() as $array) {
            yield $array;
        }
    }
}
