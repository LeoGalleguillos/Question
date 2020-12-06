<?php
namespace LeoGalleguillos\Question\Model\Service\Question;

use Exception;
use MonthlyBasis\Flash\Model\Service as FlashService;
use LeoGalleguillos\Question\Model\Entity as QuestionEntity;
use LeoGalleguillos\Question\Model\Factory as QuestionFactory;
use LeoGalleguillos\Question\Model\Service as QuestionService;
use LeoGalleguillos\Question\Model\Table as QuestionTable;
use MonthlyBasis\User\Model\Entity as UserEntity;

class Submit
{
    public function __construct(
        FlashService\Flash $flashService,
        QuestionFactory\Question $questionFactory,
        QuestionTable\Question $questionTable
    ) {
        $this->flashService    = $flashService;
        $this->questionFactory = $questionFactory;
        $this->questionTable   = $questionTable;
    }

    /**
     * Submit.
     *
     * @param UserEntity\User $userEntity
     * @return QuestionEntity\Question
     */
    public function submit(
        UserEntity\User $userEntity = null
    ): QuestionEntity\Question {
        $errors = [];

        if (empty($_POST['subject'])) {
            $errors[] = 'Invalid subject.';
        }

        if ($errors) {
            $this->flashService->set('errors', $errors);
            throw new Exception('Invalid form input.');
        }

        if ($userEntity) {
            $userId = $userEntity->getUserId();
        }

        $questionId = $this->questionTable->insert(
            $userId ?? null,
            $_POST['subject'],
            $_POST['message'] ?? null,
            $_POST['name'] ?? null,
            $_SERVER['REMOTE_ADDR']
        );

        return $this->questionFactory->buildFromQuestionId($questionId);
    }
}
