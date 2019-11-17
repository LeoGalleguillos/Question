<?php
namespace LeoGalleguillos\Question\Model\Table\Question;

use Generator;
use LeoGalleguillos\Question\Model\Table as QuestionTable;
use Zend\Db\Adapter\Adapter;

class SubjectDeletedDatetimeViewsBrowser
{
    protected $adapter;

    public function __construct(
        Adapter $adapter,
        QuestionTable\Question $questionTable
    ) {
        $this->adapter       = $adapter;
        $this->questionTable = $questionTable;
    }

    public function selectCountWhereSubjectEqualsAndDeletedDatetimeIsNull(
        string $subject
    ): int {
        $sql = '
             SELECT COUNT(*) AS `count`
              FROM `question`
             WHERE `question`.`subject` = ?
               AND `question`.`deleted_datetime` IS NULL
                 ;
        ';
        $parameters = [
            $subject,
        ];
        $array = $this->adapter->query($sql)->execute($parameters)->current();
        return (int) $array['count'];
    }

    public function selectWhereSubjectEqualsAndDeletedDatetimeIsNullOrderByViewsBrowser(
        string $subject,
        int $limitOffset,
        int $limitRowCount
    ): Generator {
        $sql = $this->questionTable->getSelect()
             . '
              FROM `question`
             WHERE `question`.`subject` = ?
               AND `question`.`deleted_datetime` IS NULL
             ORDER
                BY `question`.`views_browser` DESC
             LIMIT ?, ?
                 ;
        ';
        $parameters = [
            $subject,
            $limitOffset,
            $limitRowCount,
        ];
        foreach ($this->adapter->query($sql)->execute($parameters) as $array) {
            yield $array;
        }
    }
}
