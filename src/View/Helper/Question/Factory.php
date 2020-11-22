<?php
namespace LeoGalleguillos\Question\View\Helper\Question;

use LeoGalleguillos\Question\Model\Factory as QuestionFactory;
use Laminas\View\Helper\AbstractHelper;

class Factory extends AbstractHelper
{
    public function __construct(
        QuestionFactory\Question $questionFactory
    ) {
        $this->questionFactory = $questionFactory;
    }

    public function __invoke()
    {
        return $this->questionFactory;
    }
}
