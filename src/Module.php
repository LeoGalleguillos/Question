<?php
namespace LeoGalleguillos\Question;

use LeoGalleguillos\Flash\Model\Service as FlashService;
use LeoGalleguillos\Question\Model\Factory as QuestionFactory;
use LeoGalleguillos\Question\Model\Service as QuestionService;
use LeoGalleguillos\Question\Model\Table as QuestionTable;
use LeoGalleguillos\Question\View\Helper as QuestionHelper;
use LeoGalleguillos\Memcached\Model\Service as MemcachedService;
use LeoGalleguillos\String\Model\Service as StringService;
use LeoGalleguillos\Superglobal\Model\Service as SuperglobalService;
use LeoGalleguillos\User\Model\Factory as UserFactory;

class Module
{
    public function getConfig()
    {
        return [
            'view_helpers' => [
                'aliases' => [
                    'getAnswerFactory' => QuestionHelper\Answer\Factory::class,
                    'getQuestionFactory' => QuestionHelper\Question\Factory::class,
                    'getQuestionFromAnswer' => QuestionHelper\QuestionFromAnswer::class,
                    'getQuestionRootRelativeUrl' => QuestionHelper\Question\RootRelativeUrl::class,
                    'getQuestionTitle' => QuestionHelper\Question\Title::class,
                    'getQuestionUrl' => QuestionHelper\Question\Url::class,
                ],
                'factories' => [
                    QuestionHelper\Answer\Factory::class => function($serviceManager) {
                        return new QuestionHelper\Answer\Factory(
                            $serviceManager->get(QuestionFactory\Answer::class)
                        );
                    },
                    QuestionHelper\Question\Factory::class => function($serviceManager) {
                        return new QuestionHelper\Question\Factory(
                            $serviceManager->get(QuestionFactory\Question::class)
                        );
                    },
                    QuestionHelper\Question\RootRelativeUrl::class => function($serviceManager) {
                        return new QuestionHelper\Question\RootRelativeUrl(
                            $serviceManager->get(QuestionService\Question\RootRelativeUrl::class)
                        );
                    },
                    QuestionHelper\Question\Title::class => function($serviceManager) {
                        return new QuestionHelper\Question\Title(
                            $serviceManager->get(QuestionService\Question\Title::class)
                        );
                    },
                    QuestionHelper\Question\Url::class => function($serviceManager) {
                        return new QuestionHelper\Question\Url(
                            $serviceManager->get(QuestionService\Question\Url::class)
                        );
                    },
                    QuestionHelper\QuestionFromAnswer::class => function($serviceManager) {
                        return new QuestionHelper\QuestionFromAnswer(
                            $serviceManager->get(QuestionService\QuestionFromAnswer::class)
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
                QuestionService\Answer\Answers\Newest\CreatedName::class => function ($serviceManager) {
                    return new QuestionService\Answer\Answers\Newest\CreatedName(
                        $serviceManager->get(QuestionFactory\Answer::class),
                        $serviceManager->get(QuestionTable\Answer\CreatedName::class)
                    );
                },
                QuestionService\Answer\Count::class => function ($serviceManager) {
                    return new QuestionService\Answer\Count(
                        $serviceManager->get(QuestionTable\Answer::class)
                    );
                },
                QuestionService\Answer\Delete::class => function ($serviceManager) {
                    return new QuestionService\Answer\Delete(
                        $serviceManager->get(QuestionTable\Answer\DeletedDeletedUserIdDeletedReason::class)
                    );
                },
                QuestionService\Answer\Delete\Queue\Add::class => function ($serviceManager) {
                    return new QuestionService\Answer\Delete\Queue\Add(
                        $serviceManager->get(QuestionTable\AnswerDeleteQueue::class)
                    );
                },
                QuestionService\Answer\Delete\Queue\Approve::class => function ($serviceManager) {
                    return new QuestionService\Answer\Delete\Queue\Approve(
                        $serviceManager->get(QuestionTable\Answer\DeletedDeletedUserIdDeletedReason::class),
                        $serviceManager->get(QuestionTable\AnswerDeleteQueue::class)
                    );
                },
                QuestionService\Answer\Delete\Queue\Decline::class => function ($serviceManager) {
                    return new QuestionService\Answer\Delete\Queue\Decline(
                        $serviceManager->get(QuestionTable\AnswerDeleteQueue::class)
                    );
                },
                QuestionService\Answer\Delete\Queue\Pending::class => function ($serviceManager) {
                    return new QuestionService\Answer\Delete\Queue\Pending(
                        $serviceManager->get(QuestionTable\AnswerDeleteQueue::class)
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
                QuestionService\Answer\Edit\Queue\Approve::class => function ($serviceManager) {
                    return new QuestionService\Answer\Edit\Queue\Approve(
                        $serviceManager->get(QuestionFactory\Answer::class),
                        $serviceManager->get(QuestionService\Answer\Edit::class),
                        $serviceManager->get(QuestionTable\AnswerEditQueue::class)
                    );
                },
                QuestionService\Answer\Edit\Queue\Decline::class => function ($serviceManager) {
                    return new QuestionService\Answer\Edit\Queue\Decline(
                        $serviceManager->get(QuestionTable\AnswerEditQueue::class)
                    );
                },
                QuestionService\Answer\Edit\Queue\Pending::class => function ($serviceManager) {
                    return new QuestionService\Answer\Edit\Queue\Pending(
                        $serviceManager->get(QuestionFactory\Answer::class),
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
                QuestionService\QuestionBrowserLog::class => function ($serviceManager) {
                    return new QuestionService\QuestionBrowserLog(
                        $serviceManager->get(QuestionTable\QuestionBrowserLog::class),
                        $serviceManager->get(SuperglobalService\Server\HttpUserAgent\Browser::class)
                    );
                },
                QuestionService\QuestionFromAnswer::class => function ($serviceManager) {
                    return new QuestionService\QuestionFromAnswer(
                        $serviceManager->get(QuestionFactory\Question::class)
                    );
                },
                QuestionService\Questions::class => function ($serviceManager) {
                    return new QuestionService\Questions(
                        $serviceManager->get(QuestionFactory\Question::class),
                        $serviceManager->get(QuestionTable\Question::class)
                    );
                },
                QuestionService\Question\Delete::class => function ($serviceManager) {
                    return new QuestionService\Question\Delete(
                        $serviceManager->get(QuestionTable\Question\DeletedDeletedUserIdDeletedReason::class)
                    );
                },
                QuestionService\Question\Delete\Queue\Add::class => function ($serviceManager) {
                    return new QuestionService\Question\Delete\Queue\Add(
                        $serviceManager->get(QuestionTable\QuestionDeleteQueue::class)
                    );
                },
                QuestionService\Question\Delete\Queue\Approve::class => function ($serviceManager) {
                    return new QuestionService\Question\Delete\Queue\Approve(
                        $serviceManager->get(QuestionTable\Question\DeletedDeletedUserIdDeletedReason::class),
                        $serviceManager->get(QuestionTable\QuestionDeleteQueue::class)
                    );
                },
                QuestionService\Question\Delete\Queue\Decline::class => function ($serviceManager) {
                    return new QuestionService\Question\Delete\Queue\Decline(
                        $serviceManager->get(QuestionTable\QuestionDeleteQueue::class)
                    );
                },
                QuestionService\Question\Delete\Queue\Pending::class => function ($serviceManager) {
                    return new QuestionService\Question\Delete\Queue\Pending(
                        $serviceManager->get(QuestionTable\QuestionDeleteQueue::class)
                    );
                },
                QuestionService\Question\Duplicate::class => function ($serviceManager) {
                    return new QuestionService\Question\Duplicate(
                        $serviceManager->get(QuestionFactory\Question::class),
                        $serviceManager->get(QuestionTable\Question\MessageCreatedDatetimeDeleted::class)
                    );
                },
                QuestionService\Question\IncrementViews::class => function ($serviceManager) {
                    return new QuestionService\Question\IncrementViews(
                        $serviceManager->get(QuestionTable\Question::class)
                    );
                },
                QuestionService\Question\Questions::class => function ($serviceManager) {
                    return new QuestionService\Question\Questions(
                        $serviceManager->get(QuestionFactory\Question::class),
                        $serviceManager->get(QuestionTable\Question\DeletedCreatedDatetime::class)
                    );
                },
                QuestionService\Question\Questions\Newest\CreatedName::class => function ($serviceManager) {
                    return new QuestionService\Question\Questions\Newest\CreatedName(
                        $serviceManager->get(QuestionFactory\Question::class),
                        $serviceManager->get(QuestionTable\Question\CreatedName::class)
                    );
                },
                QuestionService\Question\Questions\Newest\WithAnswers::class => function ($serviceManager) {
                    return new QuestionService\Question\Questions\Newest\WithAnswers(
                        $serviceManager->get(QuestionFactory\Answer::class),
                        $serviceManager->get(QuestionService\Questions::class),
                        $serviceManager->get(QuestionTable\Answer::class)
                    );
                },
                QuestionService\Question\Questions\NumberOfPages::class => function ($sm) {
                    return new QuestionService\Question\Questions\NumberOfPages(
                        $sm->get(QuestionTable\Question\Deleted::class)
                    );
                },
                QuestionService\Question\Questions\Similar::class => function ($serviceManager) {
                    return new QuestionService\Question\Questions\Similar(
                        $serviceManager->get(QuestionFactory\Question::class),
                        $serviceManager->get(QuestionTable\Question::class),
                        $serviceManager->get(QuestionTable\QuestionSearchMessage::class)
                    );
                },
                QuestionService\Question\Questions\YearMonth::class => function ($serviceManager) {
                    return new QuestionService\Question\Questions\YearMonth(
                        $serviceManager->get(QuestionFactory\Question::class),
                        $serviceManager->get(QuestionTable\Question\CreatedDeletedViewsBrowser::class)
                    );
                },
                QuestionService\Question\Questions\Year::class => function ($serviceManager) {
                    return new QuestionService\Question\Questions\Year(
                        $serviceManager->get(QuestionFactory\Question::class),
                        $serviceManager->get(QuestionTable\Question\CreatedDeletedViewsBrowser::class)
                    );
                },
                QuestionService\Question\RootRelativeUrl::class => function ($serviceManager) {
                    return new QuestionService\Question\RootRelativeUrl(
                        $serviceManager->get(QuestionService\Question\Title::class),
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
                QuestionService\Question\Title::class => function ($serviceManager) {
                    return new QuestionService\Question\Title();
                },
                QuestionService\Question\Undelete::class => function ($serviceManager) {
                    return new QuestionService\Question\Undelete(
                        $serviceManager->get(QuestionTable\Question\DeletedDeletedUserIdDeletedReason::class)
                    );
                },
                QuestionService\Question\Url::class => function ($serviceManager) {
                    return new QuestionService\Question\Url(
                        $serviceManager->get(QuestionService\Question\RootRelativeUrl::class)
                    );
                },
                QuestionTable\Answer::class => function ($serviceManager) {
                    return new QuestionTable\Answer(
                        $serviceManager->get('question')
                    );
                },
                QuestionTable\Answer\CreatedName::class => function ($serviceManager) {
                    return new QuestionTable\Answer\CreatedName(
                        $serviceManager->get('question'),
                        $serviceManager->get(QuestionTable\Answer::class)
                    );
                },
                QuestionTable\Answer\CreatedIp::class => function ($serviceManager) {
                    return new QuestionTable\Answer\CreatedIp(
                        $serviceManager->get('question')
                    );
                },
                QuestionTable\Answer\CreatedIpCreatedDatetime::class => function ($sm) {
                    return new QuestionTable\Answer\CreatedIpCreatedDatetime(
                        $sm->get('question')
                    );
                },
                QuestionTable\Answer\Deleted::class => function ($serviceManager) {
                    return new QuestionTable\Answer\Deleted(
                        $serviceManager->get('question'),
                        $serviceManager->get(QuestionTable\Answer::class)
                    );
                },
                QuestionTable\Answer\DeletedDeletedUserIdDeletedReason::class => function ($serviceManager) {
                    return new QuestionTable\Answer\DeletedDeletedUserIdDeletedReason(
                        $serviceManager->get('question')
                    );
                },
                QuestionTable\Answer\DeletedUserId::class => function ($serviceManager) {
                    return new QuestionTable\Answer\DeletedUserId(
                        $serviceManager->get('question'),
                        $serviceManager->get(QuestionTable\Answer::class)
                    );
                },
                QuestionTable\Answer\Message::class => function ($serviceManager) {
                    return new QuestionTable\Answer\Message(
                        $serviceManager->get('question')
                    );
                },
                QuestionTable\AnswerDeleteQueue::class => function ($serviceManager) {
                    return new QuestionTable\AnswerDeleteQueue(
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
                QuestionTable\Question::class => function ($serviceManager) {
                    return new QuestionTable\Question(
                        $serviceManager->get('question'),
                        $serviceManager->get(MemcachedService\Memcached::class)
                    );
                },
                QuestionTable\Question\Created::class => function ($serviceManager) {
                    return new QuestionTable\Question\Created(
                        $serviceManager->get('question'),
                        $serviceManager->get(QuestionTable\Question::class)
                    );
                },
                QuestionTable\Question\DeletedCreatedDatetime::class => function ($serviceManager) {
                    return new QuestionTable\Question\DeletedCreatedDatetime(
                        $serviceManager->get('question'),
                        $serviceManager->get(QuestionTable\Question::class)
                    );
                },
                QuestionTable\Question\CreatedDeletedViewsBrowser::class => function ($serviceManager) {
                    return new QuestionTable\Question\CreatedDeletedViewsBrowser(
                        $serviceManager->get('question')
                    );
                },
                QuestionTable\Question\CreatedIp::class => function ($serviceManager) {
                    return new QuestionTable\Question\CreatedIp(
                        $serviceManager->get('question')
                    );
                },
                QuestionTable\Question\CreatedIpCreatedDatetime::class => function ($sm) {
                    return new QuestionTable\Question\CreatedIpCreatedDatetime(
                        $sm->get('question')
                    );
                },
                QuestionTable\Question\CreatedName::class => function ($serviceManager) {
                    return new QuestionTable\Question\CreatedName(
                        $serviceManager->get('question'),
                        $serviceManager->get(QuestionTable\Question::class)
                    );
                },
                QuestionTable\Question\Deleted::class => function ($serviceManager) {
                    return new QuestionTable\Question\Deleted(
                        $serviceManager->get('question'),
                        $serviceManager->get(MemcachedService\Memcached::class),
                        $serviceManager->get(QuestionTable\Question::class)
                    );
                },
                QuestionTable\Question\DeletedDeletedUserIdDeletedReason::class => function ($serviceManager) {
                    return new QuestionTable\Question\DeletedDeletedUserIdDeletedReason(
                        $serviceManager->get('question')
                    );
                },
                QuestionTable\Question\DeletedUserId::class => function ($serviceManager) {
                    return new QuestionTable\Question\DeletedUserId(
                        $serviceManager->get('question'),
                        $serviceManager->get(QuestionTable\Question::class)
                    );
                },
                QuestionTable\Question\QuestionId::class => function ($serviceManager) {
                    return new QuestionTable\Question\QuestionId(
                        $serviceManager->get('question')
                    );
                },
                QuestionTable\Question\Message::class => function ($serviceManager) {
                    return new QuestionTable\Question\Message(
                        $serviceManager->get('question'),
                        $serviceManager->get(QuestionTable\Question::class)
                    );
                },
                QuestionTable\Question\MessageCreatedDatetimeDeleted::class => function ($serviceManager) {
                    return new QuestionTable\Question\MessageCreatedDatetimeDeleted(
                        $serviceManager->get('question'),
                        $serviceManager->get(QuestionTable\Question::class)
                    );
                },
                QuestionTable\Question\Subject::class => function ($serviceManager) {
                    return new QuestionTable\Question\Subject(
                        $serviceManager->get('question')
                    );
                },
                QuestionTable\QuestionBrowserLog::class => function ($serviceManager) {
                    return new QuestionTable\QuestionBrowserLog(
                        $serviceManager->get('question')
                    );
                },
                QuestionTable\QuestionDeleteQueue::class => function ($serviceManager) {
                    return new QuestionTable\QuestionDeleteQueue(
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
                QuestionTable\QuestionSearchMessage::class => function ($serviceManager) {
                    return new QuestionTable\QuestionSearchMessage(
                        $serviceManager->get(MemcachedService\Memcached::class),
                        $serviceManager->get('question')
                    );
                },
            ],
        ];
    }
}
