<?php
namespace LeoGalleguillos\QuestionTest\Model\Factory;

use DateTime;
use LeoGalleguillos\Question\Model\Entity as QuestionEntity;
use LeoGalleguillos\Question\Model\Factory as QuestionFactory;
use LeoGalleguillos\Question\Model\Table as QuestionTable;
use LeoGalleguillos\User\Model\Factory as UserFactory;
use LeoGalleguillos\User\Model\Service as UserService;
use PHPUnit\Framework\TestCase;
use ReflectionClass;

class QuestionTest extends TestCase
{
    protected function setUp()
    {
        $this->questionTableMock = $this->createMock(
            QuestionTable\Question::class
        );
        $this->userFactoryMock = $this->createMock(
            UserFactory\User::class
        );
        $this->displayNameOrUsernameServiceMock = $this->createMock(
            UserService\DisplayNameOrUsername::class
        );
        $this->questionFactory = new QuestionFactory\Question(
            $this->questionTableMock,
            $this->userFactoryMock,
            $this->displayNameOrUsernameServiceMock
        );
    }

    public function testBuildFromArray()
    {
        $array = [
            'question_id' => 1,
            'user_id'     => null,
            'name'        => 'name',
            'subject'     => 'subject',
            'message'     => 'message',
            'created_datetime'     => '2018-03-12 22:12:23',
            'created_ip'  => '5.6.7.8',
            'deleted_datetime'     => '2018-09-17 21:42:45',
        ];
        $questionEntity = new QuestionEntity\Question();
        $questionEntity
            ->setCreatedDateTime(new DateTime($array['created_datetime']))
            ->setCreatedIp($array['created_ip'])
            ->setCreatedUserId((int) $array['user_id'])
            ->setDeletedDateTime(new DateTime($array['deleted_datetime']))
            ->setMessage($array['message'])
            ->setQuestionId($array['question_id'])
            ->setSubject($array['subject'])
            ->setUserId((int) $array['user_id'])
            ;
        $this->assertEquals(
            $questionEntity,
            $this->questionFactory->buildFromArray($array)
        );

        $array = [
            'question_id' => 1,
            'name'        => null,
            'subject'     => 'subject',
            'views'       => '123',
            'created_datetime'     => '2018-03-12 22:12:23',
        ];
        $questionEntity = new QuestionEntity\Question();
        $questionEntity->setCreatedDateTime(new DateTime($array['created_datetime']))
                       ->setQuestionId($array['question_id'])
                       ->setSubject($array['subject'])
                       ->setViews($array['views']);
        $this->assertEquals(
            $questionEntity,
            $this->questionFactory->buildFromArray($array)
        );
    }

    public function testBuildFromQuestionId()
    {
        $this->questionTableMock->method('selectWhereQuestionId')->willReturn(
            [
                'question_id' => 123,
                'user_id'     => null,
                'name'        => 'name',
                'subject'     => 'subject',
                'message'     => 'message',
                'created_datetime'     => '2018-03-12 22:12:23',
                'views'       => '123',
            ]
        );
        $questionEntity = $this->questionFactory->buildFromQuestionId(1);
        $this->assertSame(
            $questionEntity->getQuestionId(),
            123
        );
    }

    public function testGetNewInstance()
    {
        $reflectionClass = new ReflectionClass(QuestionFactory\Question::class);
        $method = $reflectionClass->getMethod('getNewInstance');
        $method->setAccessible(true);

        $this->assertInstanceOf(
            QuestionEntity\Question::class,
            $method->invoke($this->questionFactory)
        );
    }
}
