<?php
namespace LeoGalleguillos\QuestionTest\Model\Service\Answer\Delete\Queue;

use LeoGalleguillos\Question\Model\Service as QuestionService;
use LeoGalleguillos\Question\Model\Table as QuestionTable;
use PHPUnit\Framework\TestCase;

class ApproveTest extends TestCase
{
    protected function setUp(): void
    {
        $this->answerIdTableMock = $this->createMock(
            QuestionTable\Answer\AnswerId::class
        );
        $this->answerDeleteQueueTableMock = $this->createMock(
            QuestionTable\AnswerDeleteQueue::class
        );
        $this->approveService = new QuestionService\Answer\Delete\Queue\Approve(
            $this->answerIdTableMock,
            $this->answerDeleteQueueTableMock
        );
    }

    public function testApprove()
    {
        $this->answerDeleteQueueTableMock->method('selectWhereAnswerDeleteQueueId')->willReturn(
            [
                'created'   => '2018-10-08 12:51:32',
                'user_id'   => '1',
                'reason'    => 'my reason',
                'answer_id' => '2',
            ]
        );

        $this->assertNull(
            $this->approveService->approve(1)
        );
    }
}
