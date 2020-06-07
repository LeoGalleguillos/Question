<?php
namespace LeoGalleguillos\Question\Model\Service\Question\Questions;

use DateInterval;
use DateTime;
use DateTimeZone;
use Generator;
use Laminas\Db as LaminasDb;
use LeoGalleguillos\Question\Model\Factory as QuestionFactory;
use LeoGalleguillos\Question\Model\Table as QuestionTable;

class YearMonthDay
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
        int $year,
        int $month,
        int $day
    ): Generator {
        $monthPadded = sprintf('%02d', $month);
        $dayPadded   = sprintf('%02d', $day);

        $dateTimeMin = new DateTime(
            "$year-$month-$day",
            new DateTimeZone('America/New_York')
        );
        $dateTimeMin->setTimezone(new DateTimeZone('UTC'));
        $dateTimeMax = clone($dateTimeMin);
        $dateTimeMax->add(new DateInterval('P1D'))
            ->sub(new DateInterval('PT1S'));

        $select = $this->sql
            ->select('question')
            ->columns($this->questionTable->getSelectColumns())
            ->where([
                new LaminasDb\Sql\Predicate\Between(
                    'created_datetime',
                    $dateTimeMin->format('Y-m-d H:i:s'),
                    $dateTimeMax->format('Y-m-d H:i:s')
                ),
                'deleted_datetime' => null,
            ])
            ->order('views_not_bot_one_month DESC')
            ;
        $result = $this->sql->prepareStatementForSqlObject($select)->execute();

        foreach ($result as $array) {
            yield $this->questionFactory->buildFromArray($array);
        }
    }
}
