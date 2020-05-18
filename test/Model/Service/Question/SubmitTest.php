<?php
namespace LeoGalleguillos\QuestionTest\Model\Service\Question;

use Exception;
use LeoGalleguillos\Flash\Model\Service as FlashService;
use LeoGalleguillos\Question\Model\Entity as QuestionEntity;
use LeoGalleguillos\Question\Model\Factory as QuestionFactory;
use LeoGalleguillos\Question\Model\Service as QuestionService;
use LeoGalleguillos\Question\Model\Table as QuestionTable;
use PHPUnit\Framework\TestCase;

class SubmitTest extends TestCase
{
    protected function setUp(): void
    {
        $this->flashServiceMock = $this->createMock(
            FlashService\Flash::class
        );
        $this->questionFactoryMock = $this->createMock(
            QuestionFactory\Question::class
        );
        $this->questionTableMock = $this->createMock(
            QuestionTable\Question::class
        );
        $this->submitQuestionService = new QuestionService\Question\Submit(
            $this->flashServiceMock,
            $this->questionFactoryMock,
            $this->questionTableMock
        );
    }

    public function testSubmit()
    {
        $_POST = [];
        $_SERVER['REMOTE_ADDR'] = '1.2.3.4';
        try {
            $this->submitQuestionService->submit();
            $this->fail();
        } catch (Exception $exception) {
            $this->assertSame(
                'Invalid form input.',
                $exception->getMessage()
            );
        }

        $_POST['subject'] = 'this is the subject';
        $this->submitQuestionService->submit();
    }
}
