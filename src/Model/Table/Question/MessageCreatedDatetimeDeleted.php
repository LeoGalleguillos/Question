<?php
namespace LeoGalleguillos\Question\Model\Table\Question;

use LeoGalleguillos\Question\Model\Table as QuestionTable;
use Zend\Db\Adapter\Adapter;

class MessageCreatedDatetimeDeleted
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
     * Select where message and created_datetime is greater than or equal to
     * and deleted is null.
     *
     * @param string $message
     * @param string $createdDateTime
     * @return array
     */
    public function selectWhereMessageAndCreatedDateTimeIsGreaterThanOrEqualToAndDeletedIsNull(
        string $message,
        string $createdDateTime
    ): array {
        $sql = $this->questionTable->getSelect()
             .  "
              FROM `question`
             WHERE `question`.`message` = ?
               AND `question`.`created_datetime` >= ?
               AND `question`.`deleted` IS NULL
             ORDER
                BY `question`.`created_datetime` DESC
             LIMIT 1
        ";
        $parameters = [
            $message,
            $createdDateTime,
        ];
        return $this->adapter->query($sql)->execute($parameters)->current();
    }
}
