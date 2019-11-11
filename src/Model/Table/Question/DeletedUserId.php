<?php
namespace LeoGalleguillos\Question\Model\Table\Question;

use Generator;
use LeoGalleguillos\Question\Model\Table as QuestionTable;
use Zend\Db\Adapter\Adapter;

class DeletedUserId
{
    protected $adapter;

    public function __construct(
        Adapter $adapter,
        QuestionTable\Question $questionTable
    ) {
        $this->adapter       = $adapter;
        $this->questionTable = $questionTable;
    }

    public function selectWhereDeletedUserId(
        int $deletedUserId,
        int $limitRowCount
    ): Generator {
        $sql = $this->questionTable->getSelect()
             . "
              FROM `question`
             WHERE `question`.`deleted_user_id` = ?
             ORDER
                BY `question`.`deleted_datetime` DESC
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
