<?php
namespace LeoGalleguillos\Question\Model\Table\Answer;

use Generator;
use Zend\Db\Adapter\Adapter;

class Message
{
    /**
     * @var Adapter
     */
    protected $adapter;

    public function __construct(Adapter $adapter)
    {
        $this->adapter = $adapter;
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
        $sql = "
            SELECT `answer`.`answer_id`
                 , `answer`.`question_id`
                 , `answer`.`user_id`
                 , `answer`.`name`
                 , `answer`.`message`
                 , `answer`.`ip`
                 , `answer`.`created`
              FROM `answer`
             WHERE `answer`.`message` REGEXP ?
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
    public function updateWhereAnswerId(
        string $message,
        int $answerId
    ): bool {
        $sql = '
            UPDATE `answer`
               SET `answer`.`message` = ?
             WHERE `answer`.`answer_id` = ?
                 ;
        ';
        $parameters = [
            $message,
            $answerId,
        ];
        return (bool) $this->adapter
                           ->query($sql)
                           ->execute($parameters)
                           ->getAffectedRows();
    }
}
