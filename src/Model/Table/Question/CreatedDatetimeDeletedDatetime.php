<?php
namespace LeoGalleguillos\Question\Model\Table\Question;

use Generator;
use LeoGalleguillos\Question\Model\Table as QuestionTable;
use Zend\Db\Adapter\Adapter;

class CreatedDatetimeDeletedDatetime
{
    protected $adapter;

    public function __construct(
        Adapter $adapter,
        QuestionTable\Question $questionTable
    ) {
        $this->adapter       = $adapter;
        $this->questionTable = $questionTable;
    }

    public function selectWhereCreatedDatetimeIsBetweenAndDeletedDatetimeIsNull(
        string $createdDatetimeMin,
        string $createdDatetimeMax
    ): Generator {
        $sql = $this->questionTable->getSelect()
             . '
              FROM `question`
             WHERE `question`.`created_datetime` >= ?
               AND `question`.`created_datetime` < ?
               AND `question`.`deleted_datetime` IS NULL
             ORDER
                BY `question`.`created_datetime` ASC
                 ;
        ';
        $parameters = [
            $createdDatetimeMin,
            $createdDatetimeMax,
        ];
        foreach ($this->adapter->query($sql)->execute($parameters) as $array) {
            yield $array;
        }
    }
}
