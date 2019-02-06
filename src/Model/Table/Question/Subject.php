<?php
namespace LeoGalleguillos\Question\Model\Table\Question;

use Generator;
use LeoGalleguillos\Question\Model\Table as QuestionTable;
use Zend\Db\Adapter\Adapter;

class Subject
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

    public function selectWhereRegularExpression(
        string $regularExpression,
        int $limitOffset,
        int $limitRowCount
    ): Generator {
        $sql = $this->questionTable->getSelect()
             .  "
              FROM `question`
             WHERE `question`.`subject` REGEXP ?
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
        string $subject,
        int $questionId
    ): bool {
        $sql = '
            UPDATE `question`
               SET `question`.`subject` = ?
             WHERE `question`.`question_id` = ?
                 ;
        ';
        $parameters = [
            $subject,
            $questionId,
        ];
        return (bool) $this->adapter
                           ->query($sql)
                           ->execute($parameters)
                           ->getAffectedRows();
    }
}
