<?php
namespace LeoGalleguillos\Question\View\Helper\Answer;

use LeoGalleguillos\Question\Model\Factory as QuestionFactory;
use Zend\View\Helper\AbstractHelper;

class Factory extends AbstractHelper
{
    public function __construct(
        QuestionFactory\Answer $answerFactory
    ) {
        $this->answerFactory = $answerFactory;
    }

    public function __invoke()
    {
        return $this->answerFactory;
    }
}
