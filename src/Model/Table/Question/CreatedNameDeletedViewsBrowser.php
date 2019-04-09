<?php
namespace LeoGalleguillos\Question\Model\Table\Question;

use Generator;
use LeoGalleguillos\Question\Model\Table as QuestionTable;
use Zend\Db\Adapter\Adapter;

class CreatedNameDeletedViewsBrowser
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

    /**
     * @return Generator
     * @yield array
     */
    public function selectWhereCreatedNameAndDeletedIsNullOrderByViewsBrowserDesc(
        string $createdName,
        int $limitOffset,
        int $limitRowCount
    ): Generator {
        $sql = $this->questionTable->getSelect()
             . "
              FROM `question`
             WHERE `question`.`created_name` = ?
               AND `question`.`deleted` IS NULL
             ORDER
                BY `question`.`views_browser` DESC
             LIMIT $limitOffset, $limitRowCount
                 ;
        ";
        $parameters = [
            $createdName,
        ];
        foreach ($this->adapter->query($sql)->execute($parameters) as $array) {
            yield $array;
        }
    }
}
