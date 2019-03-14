<?php
namespace LeoGalleguillos\Question\Model\Service\Answer;

use DateTime;
use LeoGalleguillos\Question\Model\Table as QuestionTable;

class Duplicate
{
    public function __construct(
        QuestionTable\Answer\QuestionIdDeletedCreatedDatetime $questionIdDeletedCreatedDatetimeTable
    ) {
        $this->questionIdDeletedCreatedDatetimeTable = $questionIdDeletedCreatedDatetimeTable;
    }

    public function isDuplicate(
        int $questionId,
        string $message
    ): bool {
        $dateTime = DateTime::createFromFormat(
            'U',
            time() - 3600 // One hour ago
        );
        $count = $this
            ->questionIdDeletedCreatedDatetimeTable
            ->selectCountWhereQuestionIdCreatedDatetimeGreaterThanAndMessageEquals(
                $questionId,
                $dateTime,
                $message
        );
        return ($count > 0);
    }
}
