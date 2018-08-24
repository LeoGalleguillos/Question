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
                    'getQuestionRootRelativeUrl' => QuestionHelper\Question\RootRelativeUrl::class,
                ],
                'factories' => [
                    QuestionHelper\Question\RootRelativeUrl::class => function($serviceManager) {
                        return new QuestionHelper\Question\RootRelativeUrl(
                            $serviceManager->get(QuestionService\Question\RootRelativeUrl::class)
                        );
                    },
                ],
            ],
        ];
    }

    public function getServiceConfig()
    {
        return [
            'factories' => [
                QuestionFactory\Answer::class => function ($serviceManager) {
                    return new QuestionFactory\Answer(
                        $serviceManager->get(QuestionTable\Answer::class)
                    );
                },
                QuestionFactory\Question::class => function ($serviceManager) {
                    return new QuestionFactory\Question(
                        $serviceManager->get(QuestionTable\Question::class)
                    );
                },
                QuestionService\Answer\Answers::class => function ($serviceManager) {
                    return new QuestionService\Answer\Answers(
                        $serviceManager->get(QuestionFactory\Answer::class),
                        $serviceManager->get(QuestionTable\Answer::class)
                    );
                },
                QuestionService\Answer\Count::class => function ($serviceManager) {
                    return new QuestionService\Answer\Count(
                        $serviceManager->get(QuestionTable\Answer::class)
                    );
                },
                QuestionService\Answer\Submit::class => function ($serviceManager) {
                    return new QuestionService\Answer\Submit(
                        $serviceManager->get(FlashService\Flash::class),
                        $serviceManager->get(QuestionFactory\Answer::class),
                        $serviceManager->get(QuestionTable\Answer::class)
                    );
                },
                QuestionService\Questions::class => function ($serviceManager) {
                    return new QuestionService\Questions(
                        $serviceManager->get(QuestionFactory\Question::class),
                        $serviceManager->get(QuestionTable\Question::class)
                    );
                },
                QuestionService\Question\IncrementViews::class => function ($serviceManager) {
                    return new QuestionService\Question\IncrementViews(
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
                QuestionTable\Answer::class => function ($serviceManager) {
                    return new QuestionTable\Answer(
                        $serviceManager->get('question')
                    );
                },
                QuestionTable\AnswerMeta::class => function ($serviceManager) {
                    return new QuestionTable\AnswerMeta(
                        $serviceManager->get('question')
                    );
                },
                QuestionTable\Question::class => function ($serviceManager) {
                    return new QuestionTable\Question(
                        $serviceManager->get('question')
                    );
                },
                QuestionTable\QuestionMeta::class => function ($serviceManager) {
                    return new QuestionTable\QuestionMeta(
                        $serviceManager->get('question')
                    );
                },
            ],
        ];
    }
}
