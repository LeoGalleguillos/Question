<?php
namespace LeoGalleguillos\Question\Model\Service;

use LeoGalleguillos\Question\Model\Entity as QuestionEntity;
use LeoGalleguillos\Question\Model\Table as QuestionTable;
use LeoGalleguillos\User\Model\Entity as UserEntity;

class NumberOfPostsDeletedByUserId0InLast24Hours
{
    public function __construct(
        QuestionTable\Answer\CreatedIpDeletedDeletedUserId $answerCreatedIpDeletedDeletedUserIdTable,
        QuestionTable\Question\CreatedIpDeletedDeletedUserId $questionCreatedIpDeletedDeletedUserIdTable
    ) {
        $this->answerTable   = $answerCreatedIpDeletedDeletedUserIdTable;
        $this->questionTable = $questionCreatedIpDeletedDeletedUserIdTable;
    }

    public function getNumberOfPostsDeletedByUserInLast24Hours(
        $ipAddress
    ): int {
        $answerCount = $this->answerCreatedIpDeletedDeletedUserIdTable->selectCountWhereCreatedIpAndDeletedGreaterThanOneDayAgoAndDeletedUserIdEquals0(
            $ipAddress
        );
        $questionCount = $this->questionCreatedIpDeletedDeletedUserIdTable->selectCountWhereCreatedIpAndDeletedGreaterThanOneDayAgoAndDeletedUserIdEquals0(
            $ipAddress
        );
        return $answerCount + $questionCount;
    }
}
