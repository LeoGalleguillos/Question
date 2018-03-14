<?php
namespace LeoGalleguillos\Question;

use LeoGalleguillos\Question\Model\Factory as QuestionFactory;
use LeoGalleguillos\Question\Model\Service as QuestionService;
use LeoGalleguillos\Question\Model\Table as QuestionTable;
use LeoGalleguillos\Question\View\Helper as QuestionHelper;

class Module
{
    public function getConfig()
    {
        return [
            'view_helpers' => [
                'aliases' => [
                ],
                'factories' => [
                ],
            ],
        ];
    }

    public function getServiceConfig()
    {
        return [
            'factories' => [
                QuestionTable\Question::class => function ($serviceManager) {
                    return new QuestionTable\Question(
                        $serviceManager->get('main')
                    );
                },
            ],
        ];
    }
}
