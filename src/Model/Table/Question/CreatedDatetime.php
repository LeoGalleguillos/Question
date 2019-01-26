<?php
namespace LeoGalleguillos\Question\Model\Table\Question;

use Generator;
use LeoGalleguillos\Question\Model\Table as QuestionTable;
use Zend\Db\Adapter\Adapter;

class CreatedDatetime
{
    protected $adapter;

    public function __construct(
        Adapter $adapter,
        QuestionTable\Question $questionTable
    ) {
        $this->adapter       = $adapter;
        $this->questionTable = $questionTable;
    }

    public function selectWhereCreatedIsBetweenAndDeletedIsNull(
        string $createdMin,
        string $createdMax
    ): Generator {
        $sql = $this->questionTable->getSelect()
             . '
              FROM `question`
             WHERE `question`.`created` >= ?
               AND `question`.`created` < ?
             ORDER
                BY `question`.`created` ASC
                 ;
        ';
        $parameters = [
            $createdMin,
            $createdMax,
        ];
        foreach ($this->adapter->query($sql)->execute($parameters) as $array) {
            yield $array;
        }
    }
}
