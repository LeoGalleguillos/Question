<?php
namespace LeoGalleguillos\Question\Model\Service\Question;

use LeoGalleguillos\Question\Model\Entity as QuestionEntity;
use LeoGalleguillos\Question\Model\Service as QuestionService;
use LeoGalleguillos\String\Model\Service as StringService;

class RootRelativeUrl
{
    public function __construct(
        StringService\UrlFriendly $urlFriendlyService
    ) {
        $this->urlFriendlyService = $urlFriendlyService;
    }

    /**
     * Get root-relative URL.
     *
     * @param QuestionEntity\Question $questionEntity
     * @return string
     */
    public function getRootRelativeUrl($questionEntity) : string
    {
        return '/questions/'
             . $questionEntity->getQuestionId()
             . '/'
             . $this->urlFriendlyService->getUrlFriendly($questionEntity->getSubject());
    }
}
