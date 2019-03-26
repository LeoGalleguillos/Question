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
        QuestionTable\Question\CreatedDeletedViewsBrowser $createdDeletedViewsBrowserTable
    ) {
        $this->questionFactory                 = $questionFactory;
        $this->createdDeletedViewsBrowserTable = $createdDeletedViewsBrowserTable;
    }

    public function getQuestions(
        int $year,
        int $month,
        int $day
    ): Generator {
        $monthPadded = sprintf('%02d', $month);
        $dayPadded   = sprintf('%02d', $day);

        $dateTime = new DateTime(
            "$year-$month-$day",
            new DateTimeZone('America/New_York')
        );
        $dateTime->setTimezone(new DateTimeZone('UTC'));
        $dateTime2 = clone($dateTime);
        $dateTime2->add(new DateInterval('P1D'))
            ->sub(new DateInterval('PT1S'));

        $questionIds = $this->createdDeletedViewsBrowserTable->selectQuestionIdWhereCreatedBetweenAndDeletedIsNull(
            $dateTimeMin->format('Y-m-d H:i:s'),
            $dateTimeMax->format('Y-m-d H:i:s')
        );

        foreach ($questionIds as $questionId) {
            yield $this->questionFactory->buildFromQuestionId($questionId);
        }
    }
}
