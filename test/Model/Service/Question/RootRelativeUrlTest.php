<?php
namespace LeoGalleguillos\QuestionTest\Model\Service;

use LeoGalleguillos\Question\Model\Entity as QuestionEntity;
use LeoGalleguillos\Question\Model\Service as QuestionService;
use MonthlyBasis\String\Model\Service as StringService;
use PHPUnit\Framework\TestCase;

class RootRelativeUrlTest extends TestCase
{
    protected function setUp(): void
    {
        $this->titleServiceMock = $this->createMock(
            QuestionService\Question\Title::class
        );
        $this->urlFriendlyServiceMock   = $this->createMock(
            StringService\UrlFriendly::class
        );
        $this->rootRelativeUrlService = new QuestionService\Question\RootRelativeUrl(
            $this->titleServiceMock,
            $this->urlFriendlyServiceMock
        );
    }

    public function testInitialize()
    {
        $this->assertInstanceOf(
            QuestionService\Question\RootRelativeUrl::class,
            $this->rootRelativeUrlService
        );
    }

    public function testGetModifiedTitle()
    {
        $questionEntity            = new QuestionEntity\Question();
        $questionEntity->setQuestionId(12345);
        $questionEntity->setSubject('My Amazing Question\'s Subject (Is Great)');

        $this->urlFriendlyServiceMock->method('getUrlFriendly')->willReturn('My-Question-Title');

        $this->assertSame(
            '/questions/12345/My-Question-Title',
            $this->rootRelativeUrlService->getRootRelativeUrl($questionEntity)
        );
    }
}
