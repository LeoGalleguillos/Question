<?php
namespace LeoGalleguillos\Question\Model\Service\Question\ViewsBrowser;

use LeoGalleguillos\Question\Model\Entity as QuestionEntity;
use LeoGalleguillos\Question\Model\Table as QuestionTable;
use LeoGalleguillos\Superglobal\Model\Service as SuperglobalService;

class ConditionallyIncrement
{
    public function __construct(
        QuestionTable\Question\QuestionId $questionIdTable,
        SuperglobalService\Server\HttpUserAgent\Bot $botService
    ) {
        $this->questionIdTable = $questionIdTable;
        $this->botService      = $botService;
    }

    public function conditionallyIncrement(
        QuestionEntity\Question $questionEntity
    ): bool {
        if (!$this->botService->isBot()) {
            $this->questionIdTable->updateIncrementViewsBrowserWhereQuestionId(
                $questionEntity->getQuestionId()
            );
            return true;
        }

        return false;
    }
}
