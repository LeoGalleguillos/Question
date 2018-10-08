<?php
namespace LeoGalleguillos\QuestionTest\Model\Service\Answer\Delete\Queue;

use Exception;
use LeoGalleguillos\Question\Model\Entity as QuestionEntity;
use LeoGalleguillos\Question\Model\Factory as QuestionFactory;
use LeoGalleguillos\Question\Model\Service as QuestionService;
use LeoGalleguillos\Question\Model\Table as QuestionTable;
use LeoGalleguillos\User\Model\Entity as UserEntity;
use PHPUnit\Framework\TestCase;

class ApproveTest extends TestCase
{
    protected function setUp()
    {
        $this->deletedDeletedUserIdDeletedReasonTableMock = $this->createMock(
            QuestionTable\Answer\DeletedDeletedUserIdDeletedReason::class
        );
        $this->answerDeleteQueueTableMock = $this->createMock(
            QuestionTable\AnswerDeleteQueue::class
        );
        $this->approveService = new QuestionService\Answer\Delete\Queue\Approve(
            $this->deletedDeletedUserIdDeletedReasonTableMock,
            $this->answerDeleteQueueTableMock
        );
    }

    public function testInitialize()
    {
        $this->assertInstanceOf(
            QuestionService\Answer\Delete\Queue\Approve::class,
            $this->approveService
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
