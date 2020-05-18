<?php
namespace LeoGalleguillos\StringTest\View\Helper;

use LeoGalleguillos\Question\Model\Entity as QuestionEntity;
use LeoGalleguillos\Question\Model\Service as QuestionService;
use LeoGalleguillos\String\Model\Service as StringService;
use LeoGalleguillos\Question\View\Helper as QuestionHelper;
use PHPUnit\Framework\TestCase;

class LinkToQuestionHtmlTest extends TestCase
{
    protected function setUp(): void
    {
        $this->rootRelativeUrlServiceMock = $this->createMock(
            QuestionService\Question\RootRelativeUrl::class
        );
        $this->linkToQuestionHtmlHelper = new QuestionHelper\Question\Subject\LinkToQuestionHtml(
            $this->rootRelativeUrlServiceMock,
            new StringService\CleanUpSpaces(),
            new StringService\Escape()
        );
    }

    public function testInvoke()
    {
        $this->rootRelativeUrlServiceMock->method('getRootRelativeUrl')->will(
            $this->onConsecutiveCalls(
                '/questions/123/awesome',
                '/questions/456/fantastic'
            )
        );
        $questionEntity = new QuestionEntity\Question();
        $questionEntity->setSubject('mathematics');

        $html = $this->linkToQuestionHtmlHelper->__invoke(
            $questionEntity
        );

        $this->assertSame(
            '<a href="/questions/123/awesome">mathematics</a>',
            $html
        );

        $questionEntity->setSubject('  lots     of    spaces   !!!!!    ');

        $html = $this->linkToQuestionHtmlHelper->__invoke(
            $questionEntity
        );

        $this->assertSame(
            '<a href="/questions/456/fantastic">lots of spaces !!!!!</a>',
            $html
        );
    }
}
