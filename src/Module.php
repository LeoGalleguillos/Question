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
                    'getLinkToQuestionHtml' => QuestionHelper\Question\Subject\LinkToQuestionHtml::class,
                    'getQuestionFactory' => QuestionHelper\Question\Factory::class,
                    'getQuestionFromAnswer' => QuestionHelper\QuestionFromAnswer::class,
                    'getQuestionRootRelativeUrl' => QuestionHelper\Question\RootRelativeUrl::class,
                    'getQuestionTitle' => QuestionHelper\Question\Title::class,
                    'getQuestionUrl' => QuestionHelper\Question\Url::class,
                ],
                'factories' => [
                    QuestionHelper\Answer\Factory::class => function($sm) {
                        return new QuestionHelper\Answer\Factory(
                            $sm->get(QuestionFactory\Answer::class)
                        );
                    },
                    QuestionHelper\Question\Factory::class => function($sm) {
                        return new QuestionHelper\Question\Factory(
                            $sm->get(QuestionFactory\Question::class)
                        );
                    },
                    QuestionHelper\Question\RootRelativeUrl::class => function($sm) {
                        return new QuestionHelper\Question\RootRelativeUrl(
                            $sm->get(QuestionService\Question\RootRelativeUrl::class)
                        );
                    },
                    QuestionHelper\Question\Subject\LinkToQuestionHtml::class => function($sm) {
                        return new QuestionHelper\Question\Subject\LinkToQuestionHtml(
                            $sm->get(QuestionService\Question\RootRelativeUrl::class),
                            $sm->get(StringService\CleanUpSpaces::class),
                            $sm->get(StringService\Escape::class)

                        );
                    },
                    QuestionHelper\Question\Title::class => function($sm) {
                        return new QuestionHelper\Question\Title(
                            $sm->get(QuestionService\Question\Title::class)
                        );
                    },
                    QuestionHelper\Question\Url::class => function($sm) {
                        return new QuestionHelper\Question\Url(
                            $sm->get(QuestionService\Question\Url::class)
                        );
                    },
                    QuestionHelper\QuestionFromAnswer::class => function($sm) {
                        return new QuestionHelper\QuestionFromAnswer(
                            $sm->get(QuestionService\QuestionFromAnswer::class)
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
                QuestionFactory\Answer::class => function ($sm) {
                    return new QuestionFactory\Answer(
                        $sm->get(QuestionTable\Answer::class)
                    );
                },
                QuestionFactory\Question::class => function ($sm) {
                    return new QuestionFactory\Question(
                        $sm->get(QuestionTable\Question::class)
                    );
                },
                QuestionService\Answer\Answers::class => function ($sm) {
                    return new QuestionService\Answer\Answers(
                        $sm->get(QuestionFactory\Answer::class),
                        $sm->get(QuestionTable\Answer::class)
                    );
                },
                QuestionService\Answer\Answers\Newest::class => function ($sm) {
                    return new QuestionService\Answer\Answers\Newest(
                        $sm->get(QuestionFactory\Answer::class),
                        $sm->get(QuestionTable\Answer\DeletedCreatedDatetime::class)
                    );
                },
                QuestionService\Answer\Answers\Newest\CreatedName::class => function ($sm) {
                    return new QuestionService\Answer\Answers\Newest\CreatedName(
                        $sm->get(QuestionFactory\Answer::class),
                        $sm->get(QuestionTable\Answer\CreatedName::class)
                    );
                },
                QuestionService\Answer\Answers\User\MostPopular::class => function ($sm) {
                    return new QuestionService\Answer\Answers\User\MostPopular(
                        $sm->get(QuestionFactory\Answer::class),
                        $sm->get(QuestionTable\Answer::class)
                    );
                },
                QuestionService\Answer\Count::class => function ($sm) {
                    return new QuestionService\Answer\Count(
                        $sm->get(QuestionTable\Answer::class)
                    );
                },
                QuestionService\Answer\Delete::class => function ($sm) {
                    return new QuestionService\Answer\Delete(
                        $sm->get(QuestionTable\Answer\DeletedDeletedUserIdDeletedReason::class)
                    );
                },
                QuestionService\Answer\Delete\Queue\Add::class => function ($sm) {
                    return new QuestionService\Answer\Delete\Queue\Add(
                        $sm->get(QuestionTable\AnswerDeleteQueue::class)
                    );
                },
                QuestionService\Answer\Delete\Queue\Approve::class => function ($sm) {
                    return new QuestionService\Answer\Delete\Queue\Approve(
                        $sm->get(QuestionTable\Answer\DeletedDeletedUserIdDeletedReason::class),
                        $sm->get(QuestionTable\AnswerDeleteQueue::class)
                    );
                },
                QuestionService\Answer\Delete\Queue\Decline::class => function ($sm) {
                    return new QuestionService\Answer\Delete\Queue\Decline(
                        $sm->get(QuestionTable\AnswerDeleteQueue::class)
                    );
                },
                QuestionService\Answer\Delete\Queue\Pending::class => function ($sm) {
                    return new QuestionService\Answer\Delete\Queue\Pending(
                        $sm->get(QuestionTable\AnswerDeleteQueue::class)
                    );
                },
                QuestionService\Answer\Duplicate::class => function ($sm) {
                    return new QuestionService\Answer\Duplicate(
                        $sm->get(QuestionTable\Answer\QuestionIdDeletedCreatedDatetime::class)
                    );
                },
                QuestionService\Answer\Edit::class => function ($sm) {
                    return new QuestionService\Answer\Edit(
                        $sm->get('question'),
                        $sm->get(QuestionTable\Answer::class),
                        $sm->get(QuestionTable\AnswerHistory::class)
                    );
                },
                QuestionService\Answer\Edit\Queue::class => function ($sm) {
                    return new QuestionService\Answer\Edit\Queue(
                        $sm->get(QuestionTable\AnswerEditQueue::class)
                    );
                },
                QuestionService\Answer\Edit\Queue\Approve::class => function ($sm) {
                    return new QuestionService\Answer\Edit\Queue\Approve(
                        $sm->get(QuestionFactory\Answer::class),
                        $sm->get(QuestionService\Answer\Edit::class),
                        $sm->get(QuestionTable\AnswerEditQueue::class)
                    );
                },
                QuestionService\Answer\Edit\Queue\Decline::class => function ($sm) {
                    return new QuestionService\Answer\Edit\Queue\Decline(
                        $sm->get(QuestionTable\AnswerEditQueue::class)
                    );
                },
                QuestionService\Answer\Edit\Queue\Pending::class => function ($sm) {
                    return new QuestionService\Answer\Edit\Queue\Pending(
                        $sm->get(QuestionFactory\Answer::class),
                        $sm->get(QuestionTable\AnswerEditQueue::class)
                    );
                },
                QuestionService\Answer\Submit::class => function ($sm) {
                    return new QuestionService\Answer\Submit(
                        $sm->get(FlashService\Flash::class),
                        $sm->get(QuestionFactory\Answer::class),
                        $sm->get(QuestionTable\Answer::class)
                    );
                },
                QuestionService\Answer\Undelete::class => function ($sm) {
                    return new QuestionService\Answer\Undelete(
                        $sm->get(QuestionTable\Answer\AnswerId::class)
                    );
                },
                QuestionService\Question\Edit::class => function ($sm) {
                    return new QuestionService\Question\Edit(
                        $sm->get('question'),
                        $sm->get(QuestionTable\Question::class),
                        $sm->get(QuestionTable\QuestionHistory::class)
                    );
                },
                QuestionService\Question\Edit\Queue::class => function ($sm) {
                    return new QuestionService\Question\Edit\Queue(
                        $sm->get(QuestionTable\QuestionEditQueue::class)
                    );
                },
                QuestionService\Question\Edit\Queue\Approve::class => function ($sm) {
                    return new QuestionService\Question\Edit\Queue\Approve(
                        $sm->get(QuestionFactory\Question::class),
                        $sm->get(QuestionService\Question\Edit::class),
                        $sm->get(QuestionTable\QuestionEditQueue::class)
                    );
                },
                QuestionService\Question\Edit\Queue\Decline::class => function ($sm) {
                    return new QuestionService\Question\Edit\Queue\Decline(
                        $sm->get(QuestionTable\QuestionEditQueue::class)
                    );
                },
                QuestionService\Question\Edit\Queue\Pending::class => function ($sm) {
                    return new QuestionService\Question\Edit\Queue\Pending(
                        $sm->get(QuestionFactory\Question::class),
                        $sm->get(QuestionTable\QuestionEditQueue::class)
                    );
                },
                QuestionService\Question\ViewsBrowser\ConditionallyIncrement::class => function ($sm) {
                    return new QuestionService\Question\ViewsBrowser\ConditionallyIncrement(
                        $sm->get(QuestionTable\Question\QuestionId::class),
                        $sm->get(SuperglobalService\Server\HttpUserAgent\Browser::class)
                    );
                },
                QuestionService\QuestionFromAnswer::class => function ($sm) {
                    return new QuestionService\QuestionFromAnswer(
                        $sm->get(QuestionFactory\Question::class)
                    );
                },
                QuestionService\NumberOfPostsDeletedByUserId0InLast24Hours::class => function ($sm) {
                    return new QuestionService\NumberOfPostsDeletedByUserId0InLast24Hours(
                        $sm->get(QuestionTable\Answer\CreatedIpDeletedDeletedUserId::class),
                        $sm->get(QuestionTable\Question\CreatedIpDeletedDeletedUserId::class)
                    );
                },
                QuestionService\Questions::class => function ($sm) {
                    return new QuestionService\Questions(
                        $sm->get(QuestionFactory\Question::class),
                        $sm->get(QuestionTable\Question::class)
                    );
                },
                QuestionService\Question\Delete::class => function ($sm) {
                    return new QuestionService\Question\Delete(
                        $sm->get(QuestionTable\Question\DeletedDeletedUserIdDeletedReason::class)
                    );
                },
                QuestionService\Question\Delete\Queue\Add::class => function ($sm) {
                    return new QuestionService\Question\Delete\Queue\Add(
                        $sm->get(QuestionTable\QuestionDeleteQueue::class)
                    );
                },
                QuestionService\Question\Delete\Queue\Approve::class => function ($sm) {
                    return new QuestionService\Question\Delete\Queue\Approve(
                        $sm->get(QuestionTable\Question\DeletedDeletedUserIdDeletedReason::class),
                        $sm->get(QuestionTable\QuestionDeleteQueue::class)
                    );
                },
                QuestionService\Question\Delete\Queue\Decline::class => function ($sm) {
                    return new QuestionService\Question\Delete\Queue\Decline(
                        $sm->get(QuestionTable\QuestionDeleteQueue::class)
                    );
                },
                QuestionService\Question\Delete\Queue\Pending::class => function ($sm) {
                    return new QuestionService\Question\Delete\Queue\Pending(
                        $sm->get(QuestionTable\QuestionDeleteQueue::class)
                    );
                },
                QuestionService\Question\Duplicate::class => function ($sm) {
                    return new QuestionService\Question\Duplicate(
                        $sm->get(QuestionFactory\Question::class),
                        $sm->get(QuestionTable\Question\MessageCreatedDatetimeDeleted::class)
                    );
                },
                QuestionService\Question\IncrementViews::class => function ($sm) {
                    return new QuestionService\Question\IncrementViews(
                        $sm->get(QuestionTable\Question::class)
                    );
                },
                QuestionService\Question\Questions::class => function ($sm) {
                    return new QuestionService\Question\Questions(
                        $sm->get(QuestionFactory\Question::class),
                        $sm->get(QuestionTable\Question\DeletedCreatedDatetime::class)
                    );
                },
                QuestionService\Question\Questions\MostPopular\CreatedName::class => function ($sm) {
                    return new QuestionService\Question\Questions\MostPopular\CreatedName(
                        $sm->get(QuestionFactory\Question::class),
                        $sm->get(QuestionTable\Question\CreatedNameDeletedViewsBrowser::class)
                    );
                },
                QuestionService\Question\Questions\Newest\CreatedName::class => function ($sm) {
                    return new QuestionService\Question\Questions\Newest\CreatedName(
                        $sm->get(QuestionFactory\Question::class),
                        $sm->get(QuestionTable\Question\CreatedName::class)
                    );
                },
                QuestionService\Question\Questions\Newest\WithAnswers::class => function ($sm) {
                    return new QuestionService\Question\Questions\Newest\WithAnswers(
                        $sm->get(QuestionFactory\Answer::class),
                        $sm->get(QuestionService\Questions::class),
                        $sm->get(QuestionTable\Answer::class)
                    );
                },
                QuestionService\Question\Questions\NumberOfPages::class => function ($sm) {
                    return new QuestionService\Question\Questions\NumberOfPages(
                        $sm->get(QuestionTable\Question\Deleted::class)
                    );
                },
                QuestionService\Question\Questions\Similar::class => function ($sm) {
                    return new QuestionService\Question\Questions\Similar(
                        $sm->get(QuestionFactory\Question::class),
                        $sm->get(QuestionTable\Question::class),
                        $sm->get(QuestionTable\QuestionSearchMessage::class)
                    );
                },
                QuestionService\Question\Questions\Subject::class => function ($sm) {
                    return new QuestionService\Question\Questions\Subject(
                        $sm->get(QuestionFactory\Question::class),
                        $sm->get(QuestionTable\Question\SubjectDeletedViewsBrowser::class)
                    );
                },
                QuestionService\Question\Questions\Subject\NumberOfPages::class => function ($sm) {
                    return new QuestionService\Question\Questions\Subject\NumberOfPages(
                        $sm->get(QuestionTable\Question\SubjectDeletedViewsBrowser::class)
                    );
                },
                QuestionService\Question\Questions\Year::class => function ($sm) {
                    return new QuestionService\Question\Questions\Year(
                        $sm->get(QuestionFactory\Question::class),
                        $sm->get(QuestionTable\Question\CreatedDatetimeDeletedViewsBrowser::class)
                    );
                },
                QuestionService\Question\Questions\YearMonth::class => function ($sm) {
                    return new QuestionService\Question\Questions\YearMonth(
                        $sm->get(QuestionFactory\Question::class),
                        $sm->get(QuestionTable\Question\CreatedDatetimeDeletedViewsBrowser::class)
                    );
                },
                QuestionService\Question\Questions\YearMonthDay::class => function ($sm) {
                    return new QuestionService\Question\Questions\YearMonthDay(
                        $sm->get(QuestionFactory\Question::class),
                        $sm->get(QuestionTable\Question\CreatedDatetimeDeletedViewsBrowser::class)
                    );
                },
                QuestionService\Question\RootRelativeUrl::class => function ($sm) {
                    return new QuestionService\Question\RootRelativeUrl(
                        $sm->get(QuestionService\Question\Title::class),
                        $sm->get(StringService\UrlFriendly::class)
                    );
                },
                QuestionService\Question\Submit::class => function ($sm) {
                    return new QuestionService\Question\Submit(
                        $sm->get(FlashService\Flash::class),
                        $sm->get(QuestionFactory\Question::class),
                        $sm->get(QuestionTable\Question::class)
                    );
                },
                QuestionService\Question\Title::class => function ($sm) {
                    return new QuestionService\Question\Title();
                },
                QuestionService\Question\Undelete::class => function ($sm) {
                    return new QuestionService\Question\Undelete(
                        $sm->get(QuestionTable\Question\DeletedDeletedUserIdDeletedReason::class)
                    );
                },
                QuestionService\Question\Url::class => function ($sm) {
                    return new QuestionService\Question\Url(
                        $sm->get(QuestionService\Question\RootRelativeUrl::class)
                    );
                },
                QuestionTable\Answer::class => function ($sm) {
                    return new QuestionTable\Answer(
                        $sm->get('question')
                    );
                },
                QuestionTable\Answer\QuestionIdDeletedCreatedDatetime::class => function ($sm) {
                    return new QuestionTable\Answer\QuestionIdDeletedCreatedDatetime(
                        $sm->get('question')
                    );
                },
                QuestionTable\Answer\AnswerId::class => function ($sm) {
                    return new QuestionTable\Answer\AnswerId(
                        $sm->get('question')
                    );
                },
                QuestionTable\Answer\CreatedName::class => function ($sm) {
                    return new QuestionTable\Answer\CreatedName(
                        $sm->get('question'),
                        $sm->get(QuestionTable\Answer::class)
                    );
                },
                QuestionTable\Answer\CreatedIp::class => function ($sm) {
                    return new QuestionTable\Answer\CreatedIp(
                        $sm->get('question')
                    );
                },
                QuestionTable\Answer\CreatedIpCreatedDatetime::class => function ($sm) {
                    return new QuestionTable\Answer\CreatedIpCreatedDatetime(
                        $sm->get('question')
                    );
                },
                QuestionTable\Answer\CreatedIpDeletedDeletedUserId::class => function ($sm) {
                    return new QuestionTable\Answer\CreatedIpDeletedDeletedUserId(
                        $sm->get('question')
                    );
                },
                QuestionTable\Answer\CreatedNameDeletedCreatedDatetime::class => function ($sm) {
                    return new QuestionTable\Answer\CreatedNameDeletedCreatedDatetime(
                        $sm->get('question'),
                        $sm->get(QuestionTable\Answer::class)
                    );
                },
                QuestionTable\Answer\Deleted::class => function ($sm) {
                    return new QuestionTable\Answer\Deleted(
                        $sm->get('question'),
                        $sm->get(QuestionTable\Answer::class)
                    );
                },
                QuestionTable\Answer\DeletedCreatedDatetime::class => function ($sm) {
                    return new QuestionTable\Answer\DeletedCreatedDatetime(
                        $sm->get('question'),
                        $sm->get(QuestionTable\Answer::class)
                    );
                },
                QuestionTable\Answer\DeletedDeletedUserIdDeletedReason::class => function ($sm) {
                    return new QuestionTable\Answer\DeletedDeletedUserIdDeletedReason(
                        $sm->get('question')
                    );
                },
                QuestionTable\Answer\DeletedUserId::class => function ($sm) {
                    return new QuestionTable\Answer\DeletedUserId(
                        $sm->get('question'),
                        $sm->get(QuestionTable\Answer::class)
                    );
                },
                QuestionTable\Answer\Message::class => function ($sm) {
                    return new QuestionTable\Answer\Message(
                        $sm->get('question')
                    );
                },
                QuestionTable\AnswerDeleteQueue::class => function ($sm) {
                    return new QuestionTable\AnswerDeleteQueue(
                        $sm->get('question')
                    );
                },
                QuestionTable\AnswerEditQueue::class => function ($sm) {
                    return new QuestionTable\AnswerEditQueue(
                        $sm->get('question')
                    );
                },
                QuestionTable\AnswerHistory::class => function ($sm) {
                    return new QuestionTable\AnswerHistory(
                        $sm->get('question')
                    );
                },
                QuestionTable\Question::class => function ($sm) {
                    return new QuestionTable\Question(
                        $sm->get('question'),
                        $sm->get(MemcachedService\Memcached::class)
                    );
                },
                QuestionTable\Question\CreatedDatetimeDeleted::class => function ($sm) {
                    return new QuestionTable\Question\CreatedDatetimeDeleted(
                        $sm->get('question'),
                        $sm->get(QuestionTable\Question::class)
                    );
                },
                QuestionTable\Question\CreatedNameDeletedCreatedDatetime::class => function ($sm) {
                    return new QuestionTable\Question\CreatedNameDeletedCreatedDatetime(
                        $sm->get('question'),
                        $sm->get(QuestionTable\Question::class)
                    );
                },
                QuestionTable\Question\DeletedCreatedDatetime::class => function ($sm) {
                    return new QuestionTable\Question\DeletedCreatedDatetime(
                        $sm->get('question'),
                        $sm->get(QuestionTable\Question::class)
                    );
                },
                QuestionTable\Question\CreatedDatetimeDeletedViewsBrowser::class => function ($sm) {
                    return new QuestionTable\Question\CreatedDatetimeDeletedViewsBrowser(
                        $sm->get('question'),
                        $sm->get(QuestionTable\Question::class)
                    );
                },
                QuestionTable\Question\CreatedIpDeletedDeletedUserId::class => function ($sm) {
                    return new QuestionTable\Question\CreatedIpDeletedDeletedUserId(
                        $sm->get('question')
                    );
                },
                QuestionTable\Question\CreatedIp::class => function ($sm) {
                    return new QuestionTable\Question\CreatedIp(
                        $sm->get('question')
                    );
                },
                QuestionTable\Question\CreatedIpCreatedDatetime::class => function ($sm) {
                    return new QuestionTable\Question\CreatedIpCreatedDatetime(
                        $sm->get('question')
                    );
                },
                QuestionTable\Question\CreatedName::class => function ($sm) {
                    return new QuestionTable\Question\CreatedName(
                        $sm->get('question'),
                        $sm->get(QuestionTable\Question::class)
                    );
                },
                QuestionTable\Question\CreatedNameDeletedViewsBrowser::class => function ($sm) {
                    return new QuestionTable\Question\CreatedNameDeletedViewsBrowser(
                        $sm->get('question'),
                        $sm->get(QuestionTable\Question::class)
                    );
                },
                QuestionTable\Question\Deleted::class => function ($sm) {
                    return new QuestionTable\Question\Deleted(
                        $sm->get('question'),
                        $sm->get(MemcachedService\Memcached::class),
                        $sm->get(QuestionTable\Question::class)
                    );
                },
                QuestionTable\Question\DeletedDeletedUserIdDeletedReason::class => function ($sm) {
                    return new QuestionTable\Question\DeletedDeletedUserIdDeletedReason(
                        $sm->get('question')
                    );
                },
                QuestionTable\Question\DeletedUserId::class => function ($sm) {
                    return new QuestionTable\Question\DeletedUserId(
                        $sm->get('question'),
                        $sm->get(QuestionTable\Question::class)
                    );
                },
                QuestionTable\Question\QuestionId::class => function ($sm) {
                    return new QuestionTable\Question\QuestionId(
                        $sm->get('question')
                    );
                },
                QuestionTable\Question\Message::class => function ($sm) {
                    return new QuestionTable\Question\Message(
                        $sm->get('question'),
                        $sm->get(QuestionTable\Question::class)
                    );
                },
                QuestionTable\Question\MessageCreatedDatetimeDeleted::class => function ($sm) {
                    return new QuestionTable\Question\MessageCreatedDatetimeDeleted(
                        $sm->get('question'),
                        $sm->get(QuestionTable\Question::class)
                    );
                },
                QuestionTable\Question\Subject::class => function ($sm) {
                    return new QuestionTable\Question\Subject(
                        $sm->get('question'),
                        $sm->get(QuestionTable\Question::class)
                    );
                },
                QuestionTable\Question\SubjectDeletedViewsBrowser::class => function ($sm) {
                    return new QuestionTable\Question\SubjectDeletedViewsBrowser(
                        $sm->get('question'),
                        $sm->get(QuestionTable\Question::class)
                    );
                },
                QuestionTable\QuestionDeleteQueue::class => function ($sm) {
                    return new QuestionTable\QuestionDeleteQueue(
                        $sm->get('question')
                    );
                },
                QuestionTable\QuestionEditQueue::class => function ($sm) {
                    return new QuestionTable\QuestionEditQueue(
                        $sm->get('question')
                    );
                },
                QuestionTable\QuestionHistory::class => function ($sm) {
                    return new QuestionTable\QuestionHistory(
                        $sm->get('question')
                    );
                },
                QuestionTable\QuestionSearchMessage::class => function ($sm) {
                    return new QuestionTable\QuestionSearchMessage(
                        $sm->get(MemcachedService\Memcached::class),
                        $sm->get('question')
                    );
                },
            ],
        ];
    }
}
