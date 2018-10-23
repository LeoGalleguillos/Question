<?php
namespace LeoGalleguillos\Question\Model\Service\Question;

use LeoGalleguillos\Question\Model\Entity as QuestionEntity;
use LeoGalleguillos\Question\Model\Service as QuestionService;

class Url
{
    public function __construct(
        QuestionService\Question\RootRelativeUrl $rootRelativeUrlService
    ) {
        $this->rootRelativeUrlService = $rootRelativeUrlService;
    }

    /**
     * Get URL.
     *
     * @param QuestionEntity\Question $questionEntity
     * @return string
     */
    public function getUrl(QuestionEntity\Question $questionEntity): string
    {
        return 'https://'
             . $_SERVER['HTTP_HOST']
             . $this->rootRelativeUrlService($questionEntity);
    }
}
