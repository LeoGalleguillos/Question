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
        $this->questionFactory = new QuestionFactory\Question(
            $this->questionTableMock
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
            'subject'     => 'subject',
            'message'     => 'message',
            'created'     => '2018-03-12 22:12:23',
            'views'       => '123',
        ];

        $questionEntity = new QuestionEntity\Question();
        $questionEntity->setCreated(new DateTime($array['created']))
                       ->setMessage($array['message'])
                       ->setQuestionId($array['question_id'])
                       ->setSubject($array['subject'])
                       ->setViews($array['views']);

        $this->assertEquals(
            $questionEntity,
            $this->questionFactory->buildFromArray($array)
        );
    }
}
