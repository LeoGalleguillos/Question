<?php
namespace LeoGalleguillos\QuestionTest\Model\Factory;

use DateTime;
use LeoGalleguillos\Question\Model\Entity as QuestionEntity;
use LeoGalleguillos\Question\Model\Factory as QuestionFactory;
use LeoGalleguillos\Question\Model\Table as QuestionTable;
use PHPUnit\Framework\TestCase;

class QuestionTest extends TestCase
{
    protected function setUp()
    {
        $this->questionTableMock = $this->createMock(
            QuestionTable\Question::class
        );
        $this->questionHistoryTableMock = $this->createMock(
            QuestionTable\QuestionHistory::class
        );
        $this->questionFactory = new QuestionFactory\Question(
            $this->questionTableMock,
            $this->questionHistoryTableMock
        );
    }

    public function testInitialize()
    {
        $this->assertInstanceOf(
            QuestionFactory\Question::class,
            $this->questionFactory
        );
    }

    public function testBuildFromArray()
    {
        $array = [
            'question_id' => 1,
            'user_id'     => 1,
            'name'        => 'name',
            'subject'     => 'subject',
            'message'     => 'message',
            'ip'          => '1.2.3.4',
            'created'     => '2018-03-12 22:12:23',
        ];
        $questionEntity = new QuestionEntity\Question();
        $questionEntity->setCreated(new DateTime($array['created']))
                       ->setIp($array['ip'])
                       ->setMessage($array['message'])
                       ->setName($array['name'])
                       ->setQuestionId($array['question_id'])
                       ->setSubject($array['subject']);
        $this->assertEquals(
            $questionEntity,
            $this->questionFactory->buildFromArray($array)
        );

        $array = [
            'question_id' => 1,
            'name'        => null,
            'subject'     => 'subject',
            'ip'          => '1.2.3.4',
            'views'       => '123',
            'created'     => '2018-03-12 22:12:23',
        ];
        $questionEntity = new QuestionEntity\Question();
        $questionEntity->setCreated(new DateTime($array['created']))
                       ->setIp($array['ip'])
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
                'user_id'     => 1,
                'name'        => 'name',
                'subject'     => 'subject',
                'message'     => 'message',
                'created'     => '2018-03-12 22:12:23',
                'ip'          => '1.2.3.4',
                'views'       => '123',
            ]
        );
        $this->questionHistoryTableMock->method('selectWhereQuestionIdOrderByCreatedAscLimit1')->willReturn(
            [
                'question_id' => 123,
                'user_id'     => 2,
                'name'        => 'name',
                'subject'     => 'subject',
                'message'     => 'message',
                'created'     => '2018-02-12 22:12:23',
                'ip'          => '1.2.3.4',
                'views'       => '123',
            ]
        );
        $questionEntity = $this->questionFactory->buildFromQuestionId(1);
        $this->assertSame(
            $questionEntity->getQuestionId(),
            123
        );
    }
}
