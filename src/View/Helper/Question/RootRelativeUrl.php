<?php
namespace LeoGalleguillos\Question\View\Helper\Question;

use LeoGalleguillos\Question\Model\Entity as QuestionEntity;
use LeoGalleguillos\Question\Model\Service as QuestionService;
use Zend\View\Helper\AbstractHelper;

class RootRelativeUrl extends AbstractHelper
{
    public function __construct(
        QuestionService\Question\RootRelativeUrl $rootRelativeUrlService
    ) {
        $this->rootRelativeUrlService = $rootRelativeUrlService;
    }

    public function __invoke(QuestionEntity\Question $questionEntity)
    {
        return $this->rootRelativeUrlService->getRootRelativeUrl(
            $questionEntity
        );
    }
}
