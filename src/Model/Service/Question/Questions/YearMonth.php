<?php
namespace LeoGalleguillos\Question\Model\Service\Question\Questions;

use DateInterval;
use DateTime;
use DateTimeZone;
use Generator;
use LeoGalleguillos\Question\Model\Factory as QuestionFactory;
use LeoGalleguillos\Question\Model\Table as QuestionTable;
use TypeError;

class YearMonth
{
    public function __construct(
        QuestionFactory\Question $questionFactory,
        QuestionTable\Question\CreatedDeletedViewsBrowser $createdDeletedViewsBrowserTable
    ) {
        $this->questionFactory                 = $questionFactory;
        $this->createdDeletedViewsBrowserTable = $createdDeletedViewsBrowserTable;
    }

    public function getQuestions(
        int $year,
        int $month
    ): Generator {
        $monthPadded = sprintf('%02d', $month);

        $dateTimeMin = new DateTime(
            "$year-$month-01",
            new DateTimeZone('America/New_York')
        );
        $dateTimeMax = clone($dateTimeMin);
        $dateTimeMax->add(new DateInterval('P1M'))
            ->sub(new DateInterval('PT1S'));

        $dateTimeMin->setTimezone(new DateTimeZone('UTC'));
        $dateTimeMax->setTimezone(new DateTimeZone('UTC'));

        $arrays = $this->createdDeletedViewsBrowserTable
            ->selectWhereCreatedBetweenAndDeletedIsNullOrderByViewsBrowserDesc(
                $dateTimeMin->format('Y-m-d H:i:s'),
                $dateTimeMax->format('Y-m-d H:i:s')
            );

        foreach ($arrays as $array) {
            yield $this->questionFactory->buildFromArray($array);
        }
    }
}
