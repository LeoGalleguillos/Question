<?php
namespace LeoGalleguillos\AnswerTest\Model\Factory;

use DateTime;
use LeoGalleguillos\Question\Model\Entity as QuestionEntity;
use LeoGalleguillos\Question\Model\Factory as QuestionFactory;
use LeoGalleguillos\Question\Model\Table as QuestionTable;
use MonthlyBasis\User\Model\Entity as UserEntity;
use MonthlyBasis\User\Model\Factory as UserFactory;
use MonthlyBasis\User\Model\Service as UserService;
use PHPUnit\Framework\TestCase;

class AnswerTest extends TestCase
{
    protected function setUp(): void
    {
        $this->answerTableMock = $this->createMock(
            QuestionTable\Answer::class
        );
        $this->userFactoryMock = $this->createMock(
            UserFactory\User::class
        );
        $this->displayNameOrUsernameServiceMock = $this->createMock(
            UserService\DisplayNameOrUsername::class
        );
        $this->answerFactory = new QuestionFactory\Answer(
            $this->answerTableMock,
            $this->userFactoryMock,
            $this->displayNameOrUsernameServiceMock
        );
    }

    public function test_buildFromArray_userIdIsNull_nameIsSetFromArray()
    {
        $this->userFactoryMock
            ->expects($this->exactly(0))
            ->method('buildFromUserId')
            ;
        $this->displayNameOrUsernameServiceMock
            ->expects($this->exactly(0))
            ->method('getDisplayNameOrUsername')
            ;
        $array = [
            'answer_id'        => 1,
            'created_datetime' => '2018-03-12 22:12:23',
            'created_name'     => 'name',
            'created_ip'       => '5.6.7.8',
            'deleted_datetime' => '2018-09-18 11:23:05',
            'message'          => 'message',
            'question_id'      => 1,
            'user_id'          => null,
        ];

        $answerEntity = new QuestionEntity\Answer();
        $answerEntity
            ->setAnswerId($array['answer_id'])
            ->setCreatedDateTime(new DateTime($array['created_datetime']))
            ->setCreatedIp($array['created_ip'])
            ->setDeletedDateTime(new DateTime($array['deleted_datetime']))
            ->setMessage($array['message'])
            ->setCreatedName($array['created_name'])
            ->setQuestionId($array['question_id'])
            ;

        $this->assertEquals(
            $answerEntity,
            $this->answerFactory->buildFromArray($array)
        );
    }

    public function test_buildFromArray_userIdIsNotNull_nameIsSetFromUserService()
    {
        $userEntity = new UserEntity\User();
        $userEntity
            ->setDisplayName('i am foo')
            ->setUserId(12345)
            ->setUsername('Foo')
            ;
        $this->userFactoryMock
            ->expects($this->once())
            ->method('buildFromUserId')
            ->with(12345)
            ->willReturn($userEntity);
        $this->displayNameOrUsernameServiceMock
            ->expects($this->once())
            ->method('getDisplayNameOrUsername')
            ->with($userEntity)
            ->willReturn('i am foo');
        $array = [
            'answer_id'        => 1,
            'created_datetime' => '2018-03-12 22:12:23',
            'message'          => 'message',
            'question_id'      => 1,
            'user_id'          => 12345,
        ];
        $this->answerTableMock->method('selectWhereAnswerId')->willReturn(
            $array
        );

        $answerEntity = new QuestionEntity\Answer();
        $answerEntity
            ->setAnswerId($array['answer_id'])
            ->setCreatedDateTime(new DateTime($array['created_datetime']))
            ->setCreatedUserId($array['user_id'])
            ->setCreatedName('i am foo')
            ->setMessage($array['message'])
            ->setQuestionId($array['question_id'])
            ->setUserId($array['user_id'])
            ;

        $this->assertEquals(
            $answerEntity,
            $this->answerFactory->buildFromAnswerId(1)
        );
    }
}
