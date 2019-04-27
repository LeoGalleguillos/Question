<?php
namespace LeoGalleguillos\Question\View\Helper\Question\Subject;

use LeoGalleguillos\Question\Model\Entity as QuestionEntity;
use LeoGalleguillos\Question\Model\Service as QuestionService;
use LeoGalleguillos\String\Model\Service as StringService;
use Zend\View\Helper\AbstractHelper;

class LinkToQuestionHtml extends AbstractHelper
{
    public function __construct(
        QuestionService\Question\RootRelativeUrl $rootRelativeUrlService,
        StringService\CleanUpSpaces $cleanUpSpacesService,
        StringService\Escape $escapeService
    ) {
        $this->rootRelativeUrlService = $rootRelativeUrlService;
        $this->cleanUpSpacesService   = $cleanUpSpacesService;
        $this->escapeService          = $escapeService;
    }

    public function __invoke(QuestionEntity\Question $questionEntity)
    {
        $rru = $rootRelativeUrlService->getRootRelativeUrl($questionEntity);

        $subjectEscaped = $this->escapeService->escape(
            $questionEntity->getSubject()
        );
        $subjectEscapedAndCleaned = $this->cleanUpSpacesService->cleanUpSpaces(
            $subjectEscaped
        );

        return "<a href=\"$rru\">$subjectEscapedAndCleaned</a>";
    }
}
