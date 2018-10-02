<?php
namespace LeoGalleguillos\AnswerTest\Model\Factory;

use DateTime;
use LeoGalleguillos\Question\Model\Entity as QuestionEntity;
use LeoGalleguillos\Question\Model\Factory as QuestionFactory;
use LeoGalleguillos\Question\Model\Table as QuestionTable;
use PHPUnit\Framework\TestCase;

class AnswerTest extends TestCase
{
    protected function setUp()
    {
        $this->answerTableMock = $this->createMock(
            QuestionTable\Answer::class
        );
        $this->answerHistoryTableMock = $this->createMock(
            QuestionTable\AnswerHistory::class
        );
        $this->answerFactory = new QuestionFactory\Answer(
            $this->answerTableMock,
            $this->answerHistoryTableMock
        );
    }

    public function testInitialize()
    {
        $this->assertInstanceOf(
            QuestionFactory\Answer::class,
            $this->answerFactory
        );
    }

    public function testBuildFromArray()
    {
        $array = [
            'answer_id'   => 1,
            'question_id' => 1,
            'user_id'     => 1,
            'message'     => 'message',
            'created'     => '2018-03-12 22:12:23',
            'created_ip'  => '5.6.7.8',
            'ip'          => '1.2.3.4',
            'deleted'     => '2018-09-18 11:23:05',
        ];

        $answerEntity = new QuestionEntity\Answer();
        $answerEntity->setAnswerId($array['answer_id'])
                     ->setCreated(new DateTime($array['created']))
                     ->setCreatedIp($array['created_ip'])
                     ->setDeleted(new DateTime($array['deleted']))
                     ->setMessage($array['message'])
                     ->setIp($array['ip'])
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
            'ip'          => '1.2.3.4',
            'created'     => '2018-03-12 22:12:23',
        ];
        $this->answerTableMock->method('selectWhereAnswerId')->willReturn(
            $array
        );
        $this->answerHistoryTableMock->method('selectWhereAnswerIdOrderByCreatedAscLimit1')->willReturn(
            null
        );

        $answerEntity = new QuestionEntity\Answer();
        $answerEntity->setAnswerId($array['answer_id'])
                     ->setCreated(new DateTime($array['created']))
                     ->setMessage($array['message'])
                     ->setIp($array['ip'])
                     ->setQuestionId($array['question_id']);

        $this->assertEquals(
            $answerEntity,
            $this->answerFactory->buildFromAnswerId(1)
        );
    }
}
