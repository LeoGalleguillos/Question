<?php
namespace LeoGalleguillos\Question\Model\Table\Question;

use Generator;
use LeoGalleguillos\Question\Model\Table as QuestionTable;
use Zend\Db\Adapter\Adapter;

class CreatedDatetimeDeletedViewsBrowser
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

    public function selectWhereCreatedDatetimeBetweenAndDeletedIsNullOrderByViewsBrowserDesc(
        string $betweenMin,
        string $betweenMax
    ): Generator {
        $sql = $this->questionTable->getSelect()
             . '

              FROM `question`
             WHERE `created_datetime` between ? and ?
               AND `deleted` IS NULL

             ORDER
                BY `views_browser` DESC
                 ;
        ';
        $parameters = [
            $betweenMin,
            $betweenMax,
        ];
        foreach ($this->adapter->query($sql)->execute($parameters) as $array) {
            yield $array;
        }
    }

    public function selectWhereCreatedDatetimeBetweenAndDeletedIsNullOrderByViewsBrowserDescLimit100(
        string $betweenMin,
        string $betweenMax
    ): Generator {
        $sql = $this->questionTable->getSelect()
             . '

              FROM `question`

             FORCE
             INDEX (`created_datetime_deleted_views_browser`)

             WHERE `created_datetime` between ? and ?
               AND `deleted` IS NULL

             ORDER
                BY `views_browser` DESC

             LIMIT 100
                 ;
        ';
        $parameters = [
            $betweenMin,
            $betweenMax,
        ];
        foreach ($this->adapter->query($sql)->execute($parameters) as $array) {
            yield $array;
        }
    }
}
