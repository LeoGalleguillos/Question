<?php
namespace LeoGalleguillos\Question\Model\Table\Answer;

use Generator;
use LeoGalleguillos\Question\Model\Table as QuestionTable;
use Laminas\Db\Adapter\Adapter;

class CreatedNameDeletedCreatedDatetime
{
    /**
     * @var Adapter
     */
    protected $adapter;

    public function __construct(
        Adapter $adapter,
        QuestionTable\Answer $answerTable
    ) {
        $this->adapter     = $adapter;
        $this->answerTable = $answerTable;
    }

    public function selectWhereRegularExpression(
        string $regularExpression,
        int $limitOffset,
        int $limitRowCount
    ): Generator {
        $sql = $this->answerTable->getSelect()
             .  "
              FROM `answer`
             WHERE `answer`.`created_name` REGEXP ?
             ORDER
                BY `answer`.`created_datetime` ASC
             LIMIT $limitOffset, $limitRowCount
        ";
        $parameters = [
            $regularExpression,
        ];
        foreach ($this->adapter->query($sql)->execute($parameters) as $array) {
            yield $array;
        }
    }
}
