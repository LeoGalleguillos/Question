<?php
namespace LeoGalleguillos\QuestionTest\Model\Service\Question;

use LeoGalleguillos\Question\Model\Entity as QuestionEntity;
use LeoGalleguillos\Question\Model\Service as QuestionService;
use PHPUnit\Framework\TestCase;

class UrlTest extends TestCase
{
    protected function setUp(): void
    {
        $this->rootRelativeUrlServiceMock = $this->createMock(
            QuestionService\Question\RootRelativeUrl::class
        );
        $this->urlService = new QuestionService\Question\Url(
            $this->rootRelativeUrlServiceMock
        );
    }

    public function testInitialize()
    {
        $this->assertInstanceOf(
            QuestionService\Question\Url::class,
            $this->urlService
        );
    }

    public function testGetModifiedTitle()
    {
        $_SERVER['HTTP_HOST'] = 'www.test.com';
        $this->rootRelativeUrlServiceMock->method('getRootRelativeUrl')->willReturn(
            '/questions/12345/My-Question-Title'
        );

        $questionEntity = new QuestionEntity\Question();

        $this->assertSame(
            'https://www.test.com/questions/12345/My-Question-Title',
            $this->urlService->getUrl($questionEntity)
        );
    }
}
