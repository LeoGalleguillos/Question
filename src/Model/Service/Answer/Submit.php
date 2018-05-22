<?php
namespace LeoGalleguillos\Question\Model\Service\Answer;

use Exception;
use LeoGalleguillos\Flash\Model\Service as FlashService;
use LeoGalleguillos\Question\Model\Entity as QuestionEntity;
use LeoGalleguillos\Question\Model\Factory as QuestionFactory;
use LeoGalleguillos\Question\Model\Service as QuestionService;
use LeoGalleguillos\Question\Model\Table as QuestionTable;
use LeoGalleguillos\User\Model\Entity as UserEntity;

class Submit
{
    public function __construct(
        FlashService\Flash $flashService,
        QuestionFactory\Answer $answerFactory,
        QuestionTable\Answer $answerTable
    ) {
        $this->flashService  = $flashService;
        $this->answerFactory = $answerFactory;
        $this->answerTable   = $answerTable;
    }

    /**
     * Submit.
     *
     * @param $userId
     * @return QuestionEntity\Answer
     */
    public function submit(
        UserEntity\User $userEntity = null
    ) : QuestionEntity\Answer {
        $errors = [];

        if (empty($_POST['question_id'])) {
            $errors[] = 'Invalid question ID.';
        }
        if (empty($_POST['message'])) {
            $errors[] = 'Invalid message.';
        }

        if ($errors) {
            $this->flashService->set('errors', $errors);
            throw new Exception('Invalid form input.');
        }

        $answerId = $this->answerTable->insert(
            $_POST['question_id'],
            $userEntity->getUserId(),
            $_POST['message']
        );

        return $this->answerFactory->buildFromAnswerId($answerId);
    }
}