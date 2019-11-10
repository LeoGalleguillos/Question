<?php
namespace LeoGalleguillos\Question\Model\Table\Question;

use LeoGalleguillos\Question\Model\Table as QuestionTable;
use Zend\Db\Adapter\Adapter;

class MessageCreatedDatetimeDeletedDatetime
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

    public function selectWhereMessageAndCreatedDateTimeIsGreaterThanOrEqualToAndDeletedDatetimeIsNull(
        string $message,
        string $createdDateTime
    ): array {
        $sql = $this->questionTable->getSelect()
             .  '
              FROM `question`
             WHERE `question`.`message` = ?
               AND `question`.`created_datetime` >= ?
               AND `question`.`deleted_datetime` IS NULL
             ORDER
                BY `question`.`created_datetime` DESC
             LIMIT 1
        ';
        $parameters = [
            $message,
            $createdDateTime,
        ];
        return $this->adapter->query($sql)->execute($parameters)->current();
    }
}
