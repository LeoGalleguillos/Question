<?php
namespace LeoGalleguillos\Question\Model\Table\Question;

use Generator;
use LeoGalleguillos\Question\Model\Table as QuestionTable;
use Zend\Db\Adapter\Adapter;

class DeletedCreatedDatetime
{
    protected $adapter;

    public function __construct(
        Adapter $adapter,
        QuestionTable\Question $questionTable
    ) {
        $this->adapter       = $adapter;
        $this->questionTable = $questionTable;
    }

    public function selectQuestionIdWhereDeletedIsNullOrderByCreatedDatetimeAsc(
        int $limitOffset,
        int $limitRowCount
    ): Generator {
        $sql = '
            SELECT `question_id`
              FROM `question`
             WHERE `question`.`deleted` IS NULL
             ORDER
                BY `question`.`created_datetime` ASC
             LIMIT ?, ?
                 ;
        ';
        $parameters = [
            $limitOffset,
            $limitRowCount,
        ];
        foreach ($this->adapter->query($sql)->execute($parameters) as $array) {
            yield $array;
        }
    }

    public function selectWhereDeletedIsNullOrderByCreatedDatetimeAsc(
        int $limitOffset,
        int $limitRowCount
    ): Generator {
        $sql = $this->questionTable->getSelect()
             . '
              FROM `question`
             WHERE `question`.`deleted` IS NULL
             ORDER
                BY `question`.`created_datetime` ASC
             LIMIT ?, ?
                 ;
        ';
        $parameters = [
            $limitOffset,
            $limitRowCount,
        ];
        foreach ($this->adapter->query($sql)->execute($parameters) as $array) {
            yield $array;
        }
    }
}
