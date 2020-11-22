<?php
namespace LeoGalleguillos\Question;

use Laminas\Db as LaminasDb;
use LeoGalleguillos\Question\Model\Factory as QuestionFactory;
use LeoGalleguillos\Question\Model\Service as QuestionService;
use LeoGalleguillos\Question\Model\Table as QuestionTable;
use LeoGalleguillos\Question\View\Helper as QuestionHelper;
use LeoGalleguillos\Memcached\Model\Service as MemcachedService;
use MonthlyBasis\String\Model\Service as StringService;
use LeoGalleguillos\Superglobal\Model\Service as SuperglobalService;
use LeoGalleguillos\User\Model\Factory as UserFactory;
use LeoGalleguillos\User\Model\Service as UserService;
use MonthlyBasis\ContentModeration\Model\Service as ContentModerationService;
use MonthlyBasis\Flash\Model\Service as FlashService;

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
                            $sm->get(ContentModerationService\Replace\Spaces::class),
                            $sm->get(QuestionService\Question\RootRelativeUrl::class),
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
                'laminas-db-sql-sql' => function ($sm) {
                    return new LaminasDb\Sql\Sql(
                        $sm->get('question')
                    );
                },
                'laminas-db-table-gateway-table-gateway-question_view_not_bot_log' => function ($sm) {
                    return new LaminasDb\TableGateway\TableGateway(
                        'question_view_not_bot_log',
                        $sm->get('question')
                    );
                },
                QuestionFactory\Answer::class => function ($sm) {
                    return new QuestionFactory\Answer(
                        $sm->get(QuestionTable\Answer::class),
                        $sm->get(UserFactory\User::class),
                        $sm->get(UserService\DisplayNameOrUsername::class)
                    );
                },
                QuestionFactory\Question::class => function ($sm) {
                    return new QuestionFactory\Question(
                        $sm->get(QuestionTable\Question::class),
                        $sm->get(UserFactory\User::class),
                        $sm->get(UserService\DisplayNameOrUsername::class)
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
                        $sm->get(QuestionTable\Answer\DeletedDatetimeCreatedDatetime::class)
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
                        $sm->get(QuestionTable\Answer\AnswerId::class)
                    );
                },
                QuestionService\Answer\Delete\Queue\Add::class => function ($sm) {
                    return new QuestionService\Answer\Delete\Queue\Add(
                        $sm->get(QuestionTable\AnswerDeleteQueue::class)
                    );
                },
                QuestionService\Answer\Delete\Queue\Approve::class => function ($sm) {
                    return new QuestionService\Answer\Delete\Queue\Approve(
                        $sm->get(QuestionTable\Answer\AnswerId::class),
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
                QuestionService\Answer\Insert\Deleted::class => function ($sm) {
                    return new QuestionService\Answer\Insert\Deleted(
                        $sm->get(QuestionFactory\Answer::class),
                        $sm->get(QuestionTable\Answer::class)
                    );
                },
                QuestionService\Answer\Insert\User::class => function ($sm) {
                    return new QuestionService\Answer\Insert\User(
                        $sm->get(QuestionFactory\Answer::class),
                        $sm->get(QuestionTable\Answer::class)
                    );
                },
                QuestionService\Answer\Insert\Visitor::class => function ($sm) {
                    return new QuestionService\Answer\Insert\Visitor(
                        $sm->get(QuestionFactory\Answer::class),
                        $sm->get(QuestionTable\Answer::class)
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
                QuestionService\Question\Insert\Deleted::class => function ($sm) {
                    return new QuestionService\Question\Insert\Deleted(
                        $sm->get(QuestionFactory\Question::class),
                        $sm->get(QuestionTable\Question::class)
                    );
                },
                QuestionService\Question\Insert\User::class => function ($sm) {
                    return new QuestionService\Question\Insert\User(
                        $sm->get(QuestionFactory\Question::class),
                        $sm->get(QuestionTable\Question::class)
                    );
                },
                QuestionService\Question\Insert\Visitor::class => function ($sm) {
                    return new QuestionService\Question\Insert\Visitor(
                        $sm->get(QuestionFactory\Question::class),
                        $sm->get(QuestionTable\Question::class)
                    );
                },
                QuestionService\Question\QuestionViewNotBotLog\ConditionallyInsert::class => function ($sm) {
                    return new QuestionService\Question\QuestionViewNotBotLog\ConditionallyInsert(
                        $sm->get('laminas-db-table-gateway-table-gateway-question_view_not_bot_log'),
                        $sm->get(SuperglobalService\Server\HttpUserAgent\Bot::class)
                    );
                },
                QuestionService\QuestionFromAnswer::class => function ($sm) {
                    return new QuestionService\QuestionFromAnswer(
                        $sm->get(QuestionFactory\Question::class)
                    );
                },
                QuestionService\NumberOfPostsDeletedByUserId0InLast24Hours::class => function ($sm) {
                    return new QuestionService\NumberOfPostsDeletedByUserId0InLast24Hours(
                        $sm->get(QuestionTable\Answer\CreatedIpDeletedDatetimeDeletedUserId::class),
                        $sm->get(QuestionTable\Question\CreatedIpDeletedDatetimeDeletedUserId::class)
                    );
                },
                QuestionService\Question\Delete::class => function ($sm) {
                    return new QuestionService\Question\Delete(
                        $sm->get(QuestionTable\Question\QuestionId::class)
                    );
                },
                QuestionService\Question\Delete\Queue\Add::class => function ($sm) {
                    return new QuestionService\Question\Delete\Queue\Add(
                        $sm->get(QuestionTable\QuestionDeleteQueue::class)
                    );
                },
                QuestionService\Question\Delete\Queue\Approve::class => function ($sm) {
                    return new QuestionService\Question\Delete\Queue\Approve(
                        $sm->get(QuestionTable\Question\QuestionId::class),
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
                        $sm->get(QuestionTable\Question\MessageDeletedDatetimeCreatedDatetime::class)
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
                        $sm->get(QuestionTable\Question::class)
                    );
                },
                QuestionService\Question\Questions\MostPopular\CreatedName::class => function ($sm) {
                    return new QuestionService\Question\Questions\MostPopular\CreatedName(
                        $sm->get('laminas-db-sql-sql'),
                        $sm->get(QuestionFactory\Question::class),
                        $sm->get(QuestionTable\Question::class)
                    );
                },
                QuestionService\Question\Questions\MostPopular\Day::class => function ($sm) {
                    return new QuestionService\Question\Questions\MostPopular\Day(
                        $sm->get('laminas-db-sql-sql'),
                        $sm->get(QuestionFactory\Question::class),
                        $sm->get(QuestionTable\Question::class)
                    );
                },
                QuestionService\Question\Questions\MostPopular\Hour::class => function ($sm) {
                    return new QuestionService\Question\Questions\MostPopular\Hour(
                        $sm->get('laminas-db-sql-sql'),
                        $sm->get(QuestionFactory\Question::class),
                        $sm->get(QuestionTable\Question::class)
                    );
                },
                QuestionService\Question\Questions\MostPopular\Month::class => function ($sm) {
                    return new QuestionService\Question\Questions\MostPopular\Month(
                        $sm->get('laminas-db-sql-sql'),
                        $sm->get(QuestionFactory\Question::class),
                        $sm->get(QuestionTable\Question::class)
                    );
                },
                QuestionService\Question\Questions\MostPopular\Week::class => function ($sm) {
                    return new QuestionService\Question\Questions\MostPopular\Week(
                        $sm->get('laminas-db-sql-sql'),
                        $sm->get(QuestionFactory\Question::class),
                        $sm->get(QuestionTable\Question::class)
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
                        $sm->get(QuestionService\Question\Questions::class),
                        $sm->get(QuestionTable\Answer::class)
                    );
                },
                QuestionService\Question\Questions\Search\Results::class => function ($sm) {
                    return new QuestionService\Question\Questions\Search\Results(
                        $sm->get(QuestionFactory\Question::class),
                        $sm->get(QuestionTable\Question::class),
                        $sm->get(QuestionTable\QuestionSearchMessage::class),
                        $sm->get(StringService\KeepFirstWords::class)
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
                        $sm->get('laminas-db-sql-sql'),
                        $sm->get(QuestionFactory\Question::class)
                    );
                },
                QuestionService\Question\Questions\Subject\NumberOfPages::class => function ($sm) {
                    return new QuestionService\Question\Questions\Subject\NumberOfPages(
                        $sm->get(QuestionTable\Question\SubjectDeletedDatetimeViewsBrowser::class)
                    );
                },
                QuestionService\Question\Questions\Year::class => function ($sm) {
                    return new QuestionService\Question\Questions\Year(
                        $sm->get('laminas-db-sql-sql'),
                        $sm->get(QuestionFactory\Question::class),
                        $sm->get(QuestionTable\Question::class)
                    );
                },
                QuestionService\Question\Questions\YearMonth::class => function ($sm) {
                    return new QuestionService\Question\Questions\YearMonth(
                        $sm->get('laminas-db-sql-sql'),
                        $sm->get(QuestionFactory\Question::class),
                        $sm->get(QuestionTable\Question::class)
                    );
                },
                QuestionService\Question\Questions\YearMonthDay::class => function ($sm) {
                    return new QuestionService\Question\Questions\YearMonthDay(
                        $sm->get('laminas-db-sql-sql'),
                        $sm->get(QuestionFactory\Question::class),
                        $sm->get(QuestionTable\Question::class)
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
                    return new QuestionService\Question\Title(
                        $sm->get(StringService\StripTagsAndShorten::class)
                    );
                },
                QuestionService\Question\Undelete::class => function ($sm) {
                    return new QuestionService\Question\Undelete(
                        $sm->get(QuestionTable\Question\QuestionId::class)
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
                        $sm->get('question'),
                        $sm->get(QuestionTable\Answer::class)
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
                QuestionTable\Answer\CreatedIpDeletedDatetimeDeletedUserId::class => function ($sm) {
                    return new QuestionTable\Answer\CreatedIpDeletedDatetimeDeletedUserId(
                        $sm->get('question')
                    );
                },
                QuestionTable\Answer\CreatedNameDeletedCreatedDatetime::class => function ($sm) {
                    return new QuestionTable\Answer\CreatedNameDeletedCreatedDatetime(
                        $sm->get('question'),
                        $sm->get(QuestionTable\Answer::class)
                    );
                },
                QuestionTable\Answer\DeletedDatetime::class => function ($sm) {
                    return new QuestionTable\Answer\DeletedDatetime(
                        $sm->get('question'),
                        $sm->get(QuestionTable\Answer::class)
                    );
                },
                QuestionTable\Answer\DeletedDatetimeCreatedDatetime::class => function ($sm) {
                    return new QuestionTable\Answer\DeletedDatetimeCreatedDatetime(
                        $sm->get('question'),
                        $sm->get(QuestionTable\Answer::class)
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
                        $sm->get('question')
                    );
                },
                QuestionTable\Question\CreatedDatetimeDeletedDatetime::class => function ($sm) {
                    return new QuestionTable\Question\CreatedDatetimeDeletedDatetime(
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
                QuestionTable\Question\DeletedDatetimeCreatedDatetime::class => function ($sm) {
                    return new QuestionTable\Question\DeletedDatetimeCreatedDatetime(
                        $sm->get('question'),
                        $sm->get(QuestionTable\Question::class)
                    );
                },
                QuestionTable\Question\CreatedIpDeletedDatetimeDeletedUserId::class => function ($sm) {
                    return new QuestionTable\Question\CreatedIpDeletedDatetimeDeletedUserId(
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
                QuestionTable\Question\Deleted::class => function ($sm) {
                    return new QuestionTable\Question\Deleted(
                        $sm->get('question'),
                        $sm->get(MemcachedService\Memcached::class),
                        $sm->get(QuestionTable\Question::class)
                    );
                },
                QuestionTable\Question\DeletedDatetime::class => function ($sm) {
                    return new QuestionTable\Question\DeletedDatetime(
                        $sm->get('question'),
                        $sm->get(MemcachedService\Memcached::class),
                        $sm->get(QuestionTable\Question::class)
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
                        $sm->get('question'),
                        $sm->get(QuestionTable\Question::class)
                    );
                },
                QuestionTable\Question\Message::class => function ($sm) {
                    return new QuestionTable\Question\Message(
                        $sm->get('question'),
                        $sm->get(QuestionTable\Question::class)
                    );
                },
                QuestionTable\Question\MessageDeletedDatetimeCreatedDatetime::class => function ($sm) {
                    return new QuestionTable\Question\MessageDeletedDatetimeCreatedDatetime(
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
                QuestionTable\Question\SubjectDeletedDatetimeViewsBrowser::class => function ($sm) {
                    return new QuestionTable\Question\SubjectDeletedDatetimeViewsBrowser(
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
