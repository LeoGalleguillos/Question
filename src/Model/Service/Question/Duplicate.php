<?php
namespace LeoGalleguillos\Question\Model\Service\Question;

use DateInterval;
use DateTime;
use LeoGalleguillos\Question\Model\Entity as QuestionEntity;
use LeoGalleguillos\Question\Model\Factory as QuestionFactory;
use LeoGalleguillos\Question\Model\Service as QuestionService;
use LeoGalleguillos\Question\Model\Table as QuestionTable;
use TypeError;

class Duplicate
{
    public function __construct(
        QuestionFactory\Question $questionFactory,
        QuestionTable\Question\MessageCreatedDatetimeDeletedDatetime $messageCreatedDatetimeDeletedDatetimeTable
    ) {
        $this->questionFactory                            = $questionFactory;
        $this->messageCreatedDatetimeDeletedDatetimeTable = $messageCreatedDatetimeDeletedDatetimeTable;
    }

    /**
     * @throws TypeError
     */
    public function getDuplicate(
        string $message
    ): QuestionEntity\Question {
        $dateTime = new DateTime();
        $dateTime->sub(new DateInterval('P3D'));

        /* @throws TypeError */
        $array = $this->messageCreatedDatetimeDeletedDatetimeTable->selectWhereMessageAndCreatedDateTimeIsGreaterThanOrEqualToAndDeletedDatetimeIsNull(
            $message,
            $dateTime->format('Y-m-d H:i:s')
        );

        return $this->questionFactory->buildFromArray(
            $array
        );
    }
}
