<?php
namespace LeoGalleguillos\Question\Model\Table\Question;

use Generator;
use LeoGalleguillos\Question\Model\Table as QuestionTable;
use Zend\Db\Adapter\Adapter;

class Message
{
    /**
     * @var Adapter
     */
    protected $adapter;

    public function __construct(
        Adapter $adapter,
        QuestionTable\Question $questionTable
    ) {
        $this->adapter       = $adapter;
        $this->questionTable = $questionTable;
    }

    /**
     * @return Generator
     * @yield array
     */
    public function selectWhereMessageRegularExpression(
        string $regularExpression,
        int $limitOffset,
        int $limitRowCount
    ): Generator {
        $sql = $this->questionTable->getSelect()
             .  "
              FROM `question`
             WHERE `question`.`message` REGEXP ?
             LIMIT $limitOffset, $limitRowCount
        ";
        $parameters = [
            $regularExpression,
        ];
        foreach ($this->adapter->query($sql)->execute($parameters) as $array) {
            yield $array;
        }
    }

    /**
     * @return bool
     */
    public function updateWhereQuestionId(
        string $message,
        int $questionId
    ): bool {
        $sql = '
            UPDATE `question`
               SET `question`.`message` = ?
             WHERE `question`.`question_id` = ?
                 ;
        ';
        $parameters = [
            $message,
            $questionId,
        ];
        return (bool) $this->adapter
                           ->query($sql)
                           ->execute($parameters)
                           ->getAffectedRows();
    }
}
