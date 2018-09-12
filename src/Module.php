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
                QuestionService\Answer\Edit::class => function ($serviceManager) {
                    return new QuestionService\Answer\Edit(
                        $serviceManager->get('question'),
                        $serviceManager->get(QuestionTable\Answer::class),
                        $serviceManager->get(QuestionTable\AnswerHistory::class)
                    );
                },
                QuestionService\Answer\Edit\Queue::class => function ($serviceManager) {
                    return new QuestionService\Answer\Edit\Queue(
                        $serviceManager->get(QuestionTable\AnswerEditQueue::class)
                    );
                },
                QuestionService\Answer\Submit::class => function ($serviceManager) {
                    return new QuestionService\Answer\Submit(
                        $serviceManager->get(FlashService\Flash::class),
                        $serviceManager->get(QuestionFactory\Answer::class),
                        $serviceManager->get(QuestionTable\Answer::class)
                    );
                },
                QuestionService\Edit::class => function ($serviceManager) {
                    return new QuestionService\Edit(
                        $serviceManager->get('question'),
                        $serviceManager->get(QuestionTable\Question::class),
                        $serviceManager->get(QuestionTable\QuestionHistory::class)
                    );
                },
                QuestionService\Edit\Queue::class => function ($serviceManager) {
                    return new QuestionService\Edit\Queue(
                        $serviceManager->get(QuestionTable\QuestionEditQueue::class)
                    );
                },
                QuestionService\Edit\Queue\Approve::class => function ($serviceManager) {
                    return new QuestionService\Edit\Queue\Approve(
                        $serviceManager->get(QuestionFactory\Question::class),
                        $serviceManager->get(QuestionService\Edit::class),
                        $serviceManager->get(QuestionTable\QuestionEditQueue::class)
                    );
                },
                QuestionService\Edit\Queue\Pending::class => function ($serviceManager) {
                    return new QuestionService\Edit\Queue\Pending(
                        $serviceManager->get(QuestionFactory\Question::class),
                        $serviceManager->get(QuestionTable\QuestionEditQueue::class)
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
                QuestionTable\AnswerEditQueue::class => function ($serviceManager) {
                    return new QuestionTable\AnswerEditQueue(
                        $serviceManager->get('question')
                    );
                },
                QuestionTable\AnswerHistory::class => function ($serviceManager) {
                    return new QuestionTable\AnswerHistory(
                        $serviceManager->get('question')
                    );
                },
                QuestionTable\Answer\Deleted::class => function ($serviceManager) {
                    return new QuestionTable\Answer\Deleted(
                        $serviceManager->get('question')
                    );
                },
                QuestionTable\Question::class => function ($serviceManager) {
                    return new QuestionTable\Question(
                        $serviceManager->get('question')
                    );
                },
                QuestionTable\Question\Deleted::class => function ($serviceManager) {
                    return new QuestionTable\Question\Deleted(
                        $serviceManager->get('question')
                    );
                },
                QuestionTable\Question\Subject::class => function ($serviceManager) {
                    return new QuestionTable\Question\Subject(
                        $serviceManager->get('question')
                    );
                },
                QuestionTable\QuestionEditQueue::class => function ($serviceManager) {
                    return new QuestionTable\QuestionEditQueue(
                        $serviceManager->get('question')
                    );
                },
                QuestionTable\QuestionHistory::class => function ($serviceManager) {
                    return new QuestionTable\QuestionHistory(
                        $serviceManager->get('question')
                    );
                },
            ],
        ];
    }
}
