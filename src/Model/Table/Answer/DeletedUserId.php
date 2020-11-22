<?php
namespace LeoGalleguillos\Question\Model\Table\Answer;

use Generator;
use LeoGalleguillos\Question\Model\Table as QuestionTable;
use Laminas\Db\Adapter\Adapter;

class DeletedUserId
{
    protected $adapter;

    public function __construct(
        Adapter $adapter,
        QuestionTable\Answer $answerTable
    ) {
        $this->adapter     = $adapter;
        $this->answerTable = $answerTable;
    }

    public function selectWhereDeletedUserId(
        int $deletedUserId,
        int $limitRowCount
    ): Generator {
        $sql = $this->answerTable->getSelect()
             . "
              FROM `answer`
             WHERE `answer`.`deleted_user_id` = ?
             ORDER
                BY `answer`.`deleted_datetime` DESC
             LIMIT $limitRowCount
                 ;
        ";
        $parameters = [
            $deletedUserId,
        ];
        foreach ($this->adapter->query($sql)->execute($parameters) as $array) {
            yield $array;
        }
    }
}
