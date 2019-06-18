<?php
namespace LeoGalleguillos\Question\Model\Service\Answer\Answers\User;

use Generator;
use LeoGalleguillos\Question\Model\Factory as QuestionFactory;
use LeoGalleguillos\Question\Model\Table as QuestionTable;
use LeoGalleguillos\User\Model\Entity as UserEntity;

class MostPopular
{
    public function __construct(
        QuestionFactory\Answer $answerFactory,
        QuestionTable\Answer $answerTable
    ) {
        $this->answerFactory = $answerFactory;
        $this->answerTable   = $answerTable;
    }

    public function getAnswers(
        UserEntity\User $userEntity,
        int $page
    ): Generator {
        $arrays = $this->answerTable->selectWhereUserId(
            $userEntity->getUserId(),
            ($page - 1) * 100,
            100
        );
        foreach ($arrays as $array) {
            yield $this->answerFactory->buildFromArray($array);
        }
    }
}
