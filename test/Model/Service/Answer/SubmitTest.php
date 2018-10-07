<?php
namespace LeoGalleguillos\QuestionTest\Model\Service\Answer;

use Exception;
use LeoGalleguillos\Flash\Model\Service as FlashService;
use LeoGalleguillos\Question\Model\Entity as QuestionEntity;
use LeoGalleguillos\Question\Model\Factory as QuestionFactory;
use LeoGalleguillos\Question\Model\Service as QuestionService;
use LeoGalleguillos\Question\Model\Table as QuestionTable;
use PHPUnit\Framework\TestCase;

class SubmitTest extends TestCase
{
    protected function setUp()
    {
        $this->flashServiceMock = $this->createMock(
            FlashService\Flash::class
        );
        $this->answerFactoryMock = $this->createMock(
            QuestionFactory\Answer::class
        );
        $this->answerTableMock = $this->createMock(
            QuestionTable\Answer::class
        );
        $this->submitQuestionService = new QuestionService\Answer\Submit(
            $this->flashServiceMock,
            $this->answerFactoryMock,
            $this->answerTableMock
        );
    }

    public function testInitialize()
    {
        $this->assertInstanceOf(
            QuestionService\Answer\Submit::class,
            $this->submitQuestionService
        );
    }

    public function testSubmit()
    {
        $_SERVER['REMOTE_ADDR'] = '1.2.3.4';
        $_POST = [];
        try {
            $this->submitQuestionService->submit();
            $this->fail();
        } catch (Exception $exception) {
            $this->assertSame(
                'Invalid form input.',
                $exception->getMessage()
            );
        }

        $_POST = [
            'question-id' => '123',
            'message'     => 'this is the message',
        ];
        $this->assertInstanceOf(
            QuestionEntity\Answer::class,
            $this->submitQuestionService->submit()
        );
    }
}
