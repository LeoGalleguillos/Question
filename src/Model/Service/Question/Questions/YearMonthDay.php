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

        $sql = "
            SELECT `question`.`question_id` AS `question_id`, `question`.`user_id` AS `user_id`, `question`.`subject` AS `subject`, `question`.`message` AS `message`, `question`.`views` AS `views`, `question`.`views_not_bot_one_month` AS `views_not_bot_one_month`, `question`.`created_datetime` AS `created_datetime`, `question`.`created_name` AS `created_name`, `question`.`created_ip` AS `created_ip`, `question`.`modified_user_id` AS `modified_user_id`, `question`.`modified_datetime` AS `modified_datetime`, `question`.`modified_reason` AS `modified_reason`, `question`.`deleted_datetime` AS `deleted_datetime`, `question`.`deleted_user_id` AS `deleted_user_id`, `question`.`deleted_reason` AS `deleted_reason`

              FROM `question`

             FORCE
             INDEX (`created_datetime_deleted_datetime_views_not_bot_one_month`)

             WHERE `created_datetime` BETWEEN ? AND ?
               AND `deleted_datetime` IS NULL

             ORDER
                BY `views_not_bot_one_month` DESC
        ";
        $parameters = [
            $dateTimeMin->format('Y-m-d H:i:s'),
            $dateTimeMax->format('Y-m-d H:i:s'),
        ];
        $result = $this->sql->getAdapter()->query($sql)->execute($parameters);

        foreach ($result as $array) {
            yield $this->questionFactory->buildFromArray($array);
        }
    }
}
