<?php
namespace LeoGalleguillos\Question\Model\Service\Question\Questions\MostPopular;

use Generator;
use LeoGalleguillos\Question\Model\Factory as QuestionFactory;
use LeoGalleguillos\Question\Model\Table as QuestionTable;

class CreatedName
{
    public function __construct(
        QuestionFactory\Question $questionFactory,
        QuestionTable\Question\CreatedNameDeletedViewsBrowser $createdNameDeletedViewsBrowserTable
    ) {
        $this->questionFactory                     = $questionFactory;
        $this->createdNameDeletedViewsBrowserTable = $createdNameDeletedViewsBrowserTable;
    }

    public function getMostPopularQuestions(
        string $createdName,
        int $page
    ): Generator {
        $generator = $this->createdNameDeletedViewsBrowserTable
            ->selectWhereCreatedNameAndDeletedIsNullOrderByViewsBrowserDesc(
                $createdName,
                ($page - 1) * 100,
                100
            );

        foreach ($generator as $array) {
            yield $this->questionFactory->buildFromArray($array);
        }
    }
}
