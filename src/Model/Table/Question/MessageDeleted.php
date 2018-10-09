<?php
namespace LeoGalleguillos\Question\Model\Table\Question;

use LeoGalleguillos\Question\Model\Table as QuestionTable;
use Zend\Db\Adapter\Adapter;

class MessageDeleted
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
     * Select where message and deleted is null.
     *
     * @param string $message
     * @return array
     */
    public function selectWhereMessageAndDeletedIsNull(
        string $message
    ): array {
        $sql = $this->questionTable->getSelect()
             .  "
              FROM `question`
             WHERE `question`.`message` = ?
               AND `question`.`deleted` IS NULL
             ORDER
                BY `question`.`created_datetime` DESC
             LIMIT 1
        ";
        $parameters = [
            $message,
        ];
        return $this->adapter->query($sql)->execute($parameters)->current();
    }
}
