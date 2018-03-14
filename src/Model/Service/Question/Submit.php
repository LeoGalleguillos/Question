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
     * @param $userId,
     * @param string $subject,
     * @param string $message
     * @return QuestionEntity\Question
     */
    public function submit(
        $userId,
        string $subject,
        string $message
    ) : QuestionEntity\Question {
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

        return $this->questionFactory->buildFromQuestionId($questionId);
    }
}
