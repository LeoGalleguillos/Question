<?php
namespace LeoGalleguillos\Question\Model\Factory;

use DateTime;
use LeoGalleguillos\Question\Model\Entity as QuestionEntity;
use LeoGalleguillos\Question\Model\Table as QuestionTable;
use LeoGalleguillos\User\Model\Factory as UserFactory;
use LeoGalleguillos\User\Model\Service as UserService;

class Question
{
    public function __construct(
        QuestionTable\Question $questionTable,
        UserFactory\User $userFactory,
        UserService\DisplayNameOrUsername $displayNameOrUsernameService
    ) {
        $this->questionTable                = $questionTable;
        $this->userFactory                  = $userFactory;
        $this->displayNameOrUsernameService = $displayNameOrUsernameService;
    }

    public function buildFromArray(
        array $array
    ): QuestionEntity\Question {
        $questionEntity = static::getNewInstance();
        $questionEntity->setCreatedDateTime(new DateTime($array['created_datetime']))
                       ->setQuestionId($array['question_id'])
                       ->setSubject($array['subject']);

        if (isset($array['created_ip'])) {
            $questionEntity->setCreatedIp($array['created_ip']);
        }
        if (isset($array['created_name'])) {
            $questionEntity->setCreatedName($array['created_name']);
        }
        if (isset($array['message'])) {
            $questionEntity->setMessage($array['message']);
        }
        if (isset($array['views'])) {
            $questionEntity->setViews((int) $array['views']);
        }
        if (isset($array['deleted_datetime'])) {
            $questionEntity->setDeletedDateTime(new DateTime($array['deleted_datetime']));
        }
        if (isset($array['deleted_user_id'])) {
            $questionEntity->setDeletedUserId($array['deleted_user_id']);
        }
        if (isset($array['deleted_reason'])) {
            $questionEntity->setDeletedReason($array['deleted_reason']);
        }
        if (isset($array['user_id'])) {
            $questionEntity
                ->setUserId((int) $array['user_id'])
                ->setCreatedUserId((int) $array['user_id'])
                ;

            $userEntity = $this->userFactory->buildFromUserId(
                $array['user_id']
            );
            $questionEntity->setCreatedName(
                $this->displayNameOrUsernameService->getDisplayNameOrUsername(
                    $userEntity
                )
            );
        }

        return $questionEntity;
    }

    public function buildFromQuestionId(
        int $questionId
    ): QuestionEntity\Question {
        return $this->buildFromArray(
            $this->questionTable->selectWhereQuestionId($questionId)
        );
    }

    protected function getNewInstance(): QuestionEntity\Question
    {
        return new QuestionEntity\Question();
    }
}
