<?php
namespace LeoGalleguillos\Question\Model\Table\Question;

use Generator;
use Zend\Db\Adapter\Adapter;

class CreatedDeletedViewsBrowser
{
    /**
     * @var Adapter
     */
    protected $adapter;

    public function __construct(
        Adapter $adapter
    ) {
        $this->adapter = $adapter;
    }


    public function selectQuestionIdWhereCreatedBetweenAndDeletedIsNull(
        string $betweenMin,
        string $betweenMax
    ): Generator {
        $sql = '
            SELECT `question_id`
              from question
             where created between ? and ?
               AND deleted IS NULL

             ORDER
                BY views_browser DESC

             LIMIT 100
                 ;
        ';
        $parameters = [
            $betweenMin,
            $betweenMax,
        ];
        $questionIds = [];
        foreach ($this->adapter->query($sql)->execute($parameters) as $array) {
            yield (int) $array['question_id'];
        }
    }
}