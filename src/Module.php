<?php
namespace LeoGalleguillos\Question;

use LeoGalleguillos\Flash\Model\Service as FlashService;
use LeoGalleguillos\Question\Model\Factory as QuestionFactory;
use LeoGalleguillos\Question\Model\Service as QuestionService;
use LeoGalleguillos\Question\Model\Table as QuestionTable;
use LeoGalleguillos\Question\View\Helper as QuestionHelper;
use LeoGalleguillos\String\Model\Service as StringService;

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
                QuestionFactory\Question::class => function ($serviceManager) {
                    return new QuestionFactory\Question(
                        $serviceManager->get(QuestionTable\Question::class)
                    );
                },
                QuestionService\Questions::class => function ($serviceManager) {
                    return new QuestionService\Questions(
                        $serviceManager->get(QuestionFactory\Question::class),
                        $serviceManager->get(QuestionTable\Question::class)
                    );
                },
                QuestionService\Question\RootRelativeUrl::class => function ($serviceManager) {
                    return new QuestionService\Question\RootRelativeUrl(
                        $serviceManager->get(StringService\UrlFriendly::class)
                    );
                },
                QuestionService\Question\Submit::class => function ($serviceManager) {
                    return new QuestionService\Question\Submit(
                        $serviceManager->get(FlashService\Flash::class),
                        $serviceManager->get(QuestionFactory\Question::class),
                        $serviceManager->get(QuestionTable\Question::class)
                    );
                },
                QuestionTable\Question::class => function ($serviceManager) {
                    return new QuestionTable\Question(
                        $serviceManager->get('main')
                    );
                },
            ],
        ];
    }
}
