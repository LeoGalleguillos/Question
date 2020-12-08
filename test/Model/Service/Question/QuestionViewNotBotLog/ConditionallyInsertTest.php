<?php
namespace LeoGalleguillos\QuestionTest\Model\Service\Question\QuestionViewNotBotLog;

use Laminas\Db as LaminasDb;
use LeoGalleguillos\Question\Model\Entity as QuestionEntity;
use LeoGalleguillos\Question\Model\Service as QuestionService;
use MonthlyBasis\Superglobal\Model\Service as SuperglobalService;
use PHPUnit\Framework\TestCase;

class UrlTest extends TestCase
{
    protected function setUp(): void
    {
        $this->questionViewNotBotLogTableGatewayMock = $this->createMock(
            LaminasDb\TableGateway\TableGateway::class
        );
        $this->botServiceMock = $this->createMock(
            SuperglobalService\Server\HttpUserAgent\Bot::class
        );

        $this->conditionallyInsertService = new QuestionService\Question\QuestionViewNotBotLog\ConditionallyInsert(
            $this->questionViewNotBotLogTableGatewayMock,
            $this->botServiceMock
        );
    }

    public function test_conditionallyInsert_isBot_noInsert()
    {
        $this->botServiceMock
            ->expects($this->once())
            ->method('isBot')
            ->willReturn(true);
        $this->questionViewNotBotLogTableGatewayMock
            ->expects($this->exactly(0))
            ->method('insert');
        $_SERVER['REMOTE_ADDR'] = '1.2.3.4';
        $questionEntity = (new QuestionEntity\Question())
            ->setQuestionId(12345);
        $result = $this->conditionallyInsertService->conditionallyInsert(
            $questionEntity
        );
        $this->assertFalse($result);
    }

    public function test_conditionallyInsert_isNotBot_insert()
    {
        $this->botServiceMock
            ->expects($this->once())
            ->method('isBot')
            ->willReturn(false);
        $this->questionViewNotBotLogTableGatewayMock
            ->expects($this->once())
            ->method('insert')
            ->with([
                'question_id' => 12345,
                'ip' => '1.2.3.4',
            ]);
        $_SERVER['REMOTE_ADDR'] = '1.2.3.4';
        $questionEntity = (new QuestionEntity\Question())
            ->setQuestionId(12345);
        $result = $this->conditionallyInsertService->conditionallyInsert(
            $questionEntity
        );
        $this->assertTrue($result);
    }
}
