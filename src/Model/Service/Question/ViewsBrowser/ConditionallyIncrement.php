<?php
namespace LeoGalleguillos\Question\Model\Service\Question\ViewsBrowser;

use LeoGalleguillos\Question\Model\Entity as QuestionEntity;
use LeoGalleguillos\Question\Model\Table as QuestionTable;
use LeoGalleguillos\Superglobal\Model\Service as SuperglobalService;

class ConditionallyIncrement
{
    public function __construct(
        QuestionTable\Question\QuestionId $questionIdTable,
        SuperglobalService\Server\HttpUserAgent\Browser $browserService
    ) {
        $this->questionIdTable = $questionIdTable;
        $this->browserService  = $browserService;
    }

    public function conditionallyIncrement(
        QuestionEntity\Question $questionEntity
    ): bool {
        if ($this->browserService->isBrowser()) {
            $this->questionIdTable->updateIncrementViewsBrowserWhereQuestionId(
                $questionEntity->getQuestionId()
            );
            return true;
        }

        return false;
    }
}
