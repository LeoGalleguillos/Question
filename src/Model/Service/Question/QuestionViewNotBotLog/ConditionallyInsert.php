<?php
namespace LeoGalleguillos\Question\Model\Service\Question\QuestionViewNotBotLog;

use Laminas\Db as LaminasDb;
use LeoGalleguillos\Question\Model\Entity as QuestionEntity;
use LeoGalleguillos\Superglobal\Model\Service as SuperglobalService;

class ConditionallyInsert
{
    public function __construct(
        LaminasDb\TableGateway\TableGateway $questionViewNotBotLogTableGateway,
        SuperglobalService\Server\HttpUserAgent\Bot $botService
    ) {
        $this->questionViewNotBotLogTableGateway = $questionViewNotBotLogTableGateway;
        $this->botService                        = $botService;
    }

    public function conditionallyInsert(QuestionEntity\Question $questionEntity): bool
    {
        if (!$this->botService->isBot()) {
            $this->questionViewNotBotLogTableGateway
                ->insert([
                    'question_id' => $questionEntity->getQuestionId(),
                    'ip' => $_SERVER['REMOTE_ADDR'],
                ]);
            return true;
        }

        return false;
    }
}
