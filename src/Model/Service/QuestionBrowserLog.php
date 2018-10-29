<?php
namespace LeoGalleguillos\Question\Model\Service;

use LeoGalleguillos\Question\Model\Entity as QuestionEntity;
use LeoGalleguillos\Question\Model\Table as QuestionTable;
use LeoGalleguillos\Superglobal\Model\Service as SuperglobalService;

class QuestionBrowserLog
{
    public function __construct(
        QuestionTable\QuestionBrowserLog $questionBrowserLogTable,
        SuperglobalService\Server\HttpUserAgent\Browser $browserService
    ) {
        $this->questionBrowserLogTable = $questionBrowserLogTable;
        $this->browserService          = $browserService;
    }

    public function conditionallyInsert(
        QuestionEntity\Question $questionEntity
    ): bool {
        if ($this->browserService->isBrowser()) {
            $httpUserAgent = (strlen($_SERVER['HTTP_USER_AGENT']) > 255)
                           ? substr($_SERVER['HTTP_USER_AGENT'], 0, 255)
                           : $_SERVER['HTTP_USER_AGENT'];

            $this->questionBrowserLogTable->insert(
                $questionEntity->getQuestionId(),
                $_SERVER['REMOTE_ADDR'],
                $httpUserAgent
            );
            return true;
        }

        return false;
    }
}
