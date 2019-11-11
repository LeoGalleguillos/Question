<?php
namespace LeoGalleguillos\Question\Model\Service\Question\Questions;

use DateInterval;
use DateTime;
use DateTimeZone;
use Generator;
use LeoGalleguillos\Question\Model\Factory as QuestionFactory;
use LeoGalleguillos\Question\Model\Table as QuestionTable;

class YearMonthDay
{
    public function __construct(
        QuestionFactory\Question $questionFactory,
        QuestionTable\Question\CreatedDatetimeDeletedDatetimeViewsBrowser $createdDatetimeDeletedDatetimeViewsBrowserTable
    ) {
        $this->questionFactory                                 = $questionFactory;
        $this->createdDatetimeDeletedDatetimeViewsBrowserTable = $createdDatetimeDeletedDatetimeViewsBrowserTable;
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

        $arrays = $this->createdDatetimeDeletedDatetimeViewsBrowserTable
            ->selectWhereCreatedDatetimeBetweenAndDeletedDatetimeIsNullOrderByViewsBrowserDesc(
                $dateTimeMin->format('Y-m-d H:i:s'),
                $dateTimeMax->format('Y-m-d H:i:s')
            );

        foreach ($arrays as $array) {
            yield $this->questionFactory->buildFromArray($array);
        }
    }
}
