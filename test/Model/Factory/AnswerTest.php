<?php
namespace LeoGalleguillos\AnswerTest\Model\Factory;

use DateTime;
use LeoGalleguillos\Question\Model\Entity as QuestionEntity;
use LeoGalleguillos\Question\Model\Factory as QuestionFactory;
use LeoGalleguillos\Question\Model\Table as QuestionTable;
use LeoGalleguillos\User\Model\Entity as UserEntity;
use LeoGalleguillos\User\Model\Factory as UserFactory;
use LeoGalleguillos\User\Model\Service as UserService;
use PHPUnit\Framework\TestCase;

class AnswerTest extends TestCase
{
    protected function setUp()
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

    public function testBuildFromArray()
    {
        $array = [
            'answer_id'        => 1,
            'question_id'      => 1,
            'user_id'          => null,
            'message'          => 'message',
            'created_datetime' => '2018-03-12 22:12:23',
            'created_ip'       => '5.6.7.8',
            'deleted'          => '2018-09-18 11:23:05',
            'deleted_datetime' => '2018-09-18 11:23:05',
        ];

        $answerEntity = new QuestionEntity\Answer();
        $answerEntity->setAnswerId($array['answer_id'])
                     ->setCreatedDateTime(new DateTime($array['created_datetime']))
                     ->setCreatedIp($array['created_ip'])
                     ->setDeletedDateTime(new DateTime($array['deleted']))
                     ->setMessage($array['message'])
                     ->setQuestionId($array['question_id']);

        $this->assertEquals(
            $answerEntity,
            $this->answerFactory->buildFromArray($array)
        );
    }

    public function testBuildFromAnswerId()
    {
        $array = [
            'answer_id'   => 1,
            'question_id' => 1,
            'user_id'     => 1,
            'message'     => 'message',
            'created_datetime'     => '2018-03-12 22:12:23',
        ];
        $this->answerTableMock->method('selectWhereAnswerId')->willReturn(
            $array
        );

        $answerEntity = new QuestionEntity\Answer();
        $answerEntity->setAnswerId($array['answer_id'])
                     ->setCreatedDateTime(new DateTime($array['created_datetime']))
                     ->setMessage($array['message'])
                     ->setQuestionId($array['question_id'])
                     ->setUserId($array['user_id']);

        $this->assertEquals(
            $answerEntity,
            $this->answerFactory->buildFromAnswerId(1)
        );
    }
}
