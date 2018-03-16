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
        $this->answerFactory = new QuestionFactory\Answer(
            $this->answerTableMock
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
        ];

        $answerEntity = new QuestionEntity\Answer();
        $answerEntity->setAnswerId($array['answer_id'])
                     ->setCreated(new DateTime($array['created']))
                     ->setMessage($array['message'])
                     ->setQuestionId($array['question_id']);

        $this->assertEquals(
            $answerEntity,
            $this->answerFactory->buildFromArray($array)
        );
    }
}
