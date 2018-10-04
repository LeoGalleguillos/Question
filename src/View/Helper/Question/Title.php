<?php
namespace LeoGalleguillos\Question\View\Helper\Question;

use LeoGalleguillos\Question\Model\Entity as QuestionEntity;
use LeoGalleguillos\Question\Model\Service as QuestionService;
use Zend\View\Helper\AbstractHelper;

class Title extends AbstractHelper
{
    public function __construct(
        QuestionService\Question\Title $titleService
    ) {
        $this->titleService = $titleService;
    }

    public function __invoke(QuestionEntity\Question $questionEntity)
    {
        return $this->titleService->getTitle(
            $questionEntity
        );
    }
}
