<?php
namespace LeoGalleguillos\Question\Model\Service\Question;

use Exception;
use LeoGalleguillos\Flash\Model\Service as FlashService;
use LeoGalleguillos\Question\Model\Entity as QuestionEntity;
use LeoGalleguillos\Question\Model\Factory as QuestionFactory;
use LeoGalleguillos\Question\Model\Service as QuestionService;
use LeoGalleguillos\Question\Model\Table as QuestionTable;

class Submit
{
    public function __construct(
        FlashService\Flash $flashService
        QuestionTable\Question $questionTable
    ) {
        $this->flashService  = $flashService;
        $this->questionTable = $questionTable;
    }

    /**
     * Submit.
     */
    public function submit(
        $userId,
        string $subject,
        string $message
    ) : array {
        $errors = [];

        if (empty($subject)) {
            $errors[] = 'Invalid subject.';
        }
        if (empty($message)) {
            $errors[] = 'Invalid message.';
        }

        if ($errors) {
            $this->flashService->set('errors', $errors);
            throw new Exception('Invalid form input.');
        }

        $questionId = $this->questionTable->insert(
            $userId,
            $subject,
            $message
        );

        return [];
    }
}
