<?php
namespace LeoGalleguillos\Question\Model\Service\Question\Questions;

use Generator;
use Laminas\Db as LaminasDb;
use LeoGalleguillos\Question\Model\Factory as QuestionFactory;
use LeoGalleguillos\Question\Model\Table as QuestionTable;

class Year
{
    public function __construct(
        LaminasDb\Sql\Sql $sql,
        QuestionFactory\Question $questionFactory,
        QuestionTable\Question $questionTable
    ) {
        $this->sql             = $sql;
        $this->questionFactory = $questionFactory;
        $this->questionTable   = $questionTable;
    }

    public function getQuestions(
        int $year
    ): Generator {
        $betweenMin = "$year-01-01 05:00:00";
        $betweenMax = ($year + 1) . "-01-01 04:59:59";

        $select = $this->sql
            ->select('question')
            ->columns($this->questionTable->getSelectColumns())
            ->where([
                new LaminasDb\Sql\Predicate\Between('created_datetime', $betweenMin, $betweenMax),
                'deleted_datetime' => null,
            ])
            ->order('views_not_bot_one_month DESC')
            ->limit(100)
            ->offset(0)
            ;
        $result = $this->sql->prepareStatementForSqlObject($select)->execute();

        foreach ($result as $array) {
            yield $this->questionFactory->buildFromArray($array);
        }
    }
}
