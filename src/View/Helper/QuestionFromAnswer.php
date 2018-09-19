<?php
namespace LeoGalleguillos\Question\View\Helper;

use LeoGalleguillos\Question\Model\Entity as QuestionEntity;
use LeoGalleguillos\Question\Model\Service as QuestionService;
use Zend\View\Helper\AbstractHelper;

class QuestionFromAnswer extends AbstractHelper
{
    public function __construct(
        QuestionService\QuestionFromAnswer $questionFromAnswerService
    ) {
        $this->rootRelativeUrlService = $questionFromAnswerService;
    }

    public function __invoke(QuestionEntity\Answer $answerEntity)
    {
        return $this->questionFromAnswerService->getQuestionFromAnswer(
            $answerEntity
        );
    }
}
