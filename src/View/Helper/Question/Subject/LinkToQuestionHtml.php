<?php
namespace LeoGalleguillos\Question\View\Helper\Question\Subject;

use Laminas\View\Helper\AbstractHelper;
use LeoGalleguillos\Question\Model\Entity as QuestionEntity;
use LeoGalleguillos\Question\Model\Service as QuestionService;
use LeoGalleguillos\String\Model\Service as StringService;
use MonthlyBasis\ContentModeration\Model\Service as ContentModerationService;

class LinkToQuestionHtml extends AbstractHelper
{
    public function __construct(
        ContentModerationService\Replace\Spaces $spacesService,
        QuestionService\Question\RootRelativeUrl $rootRelativeUrlService,
        StringService\Escape $escapeService
    ) {
        $this->spacesService          = $spacesService;
        $this->rootRelativeUrlService = $rootRelativeUrlService;
        $this->escapeService          = $escapeService;
    }

    public function __invoke(QuestionEntity\Question $questionEntity)
    {
        $rru = $this->rootRelativeUrlService->getRootRelativeUrl(
            $questionEntity
        );

        $subjectEscaped = $this->escapeService->escape(
            $questionEntity->getSubject()
        );
        $subjectEscapedAndCleaned = $this->spacesService->replaceSpaces(
            $subjectEscaped
        );

        return "<a href=\"$rru\">$subjectEscapedAndCleaned</a>";
    }
}
