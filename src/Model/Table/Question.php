<?php
namespace LeoGalleguillos\Question\Model\Table;

use Exception;
use Generator;
use Zend\Db\Adapter\Adapter;

class Question
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
     * @return int
     */
    public function insert(
        int $userId = null,
        string $name = null,
        string $subject,
        string $message = null
    ) : int {
        $sql = '
            INSERT
              INTO `question` (
                   `user_id`, `name`, `subject`, `message`, `created`
                   )
            VALUES (?, ?, ?, ?, UTC_TIMESTAMP())
                 ;
        ';
        $parameters = [
            $userId,
            $name,
            $subject,
            $message,
        ];
        return $this->adapter
                    ->query($sql)
                    ->execute($parameters)
                    ->getGeneratedValue();
    }

    /**
     * @return int
     */
    public function insertQuestionIdSubjectMessageIp(
        int $questionId,
        string $name,
        string $subject,
        string $message,
        string $ip
    ): int {
        $sql = '
            INSERT
              INTO `question` (
                       `question_id`
                     , `name`
                     , `subject`
                     , `message`
                     , `ip`
                     , `created`
                   )
            VALUES (?, ?, ?, ?, ?, UTC_TIMESTAMP())
                 ;
        ';
        $parameters = [
            $questionId,
            $name,
            $subject,
            $message,
            $ip,
        ];
        return (int) $this->adapter
                          ->query($sql)
                          ->execute($parameters)
                          ->getGeneratedValue();
    }

    public function selectCount()
    {
        $sql = '
            SELECT COUNT(*) AS `count`
              FROM `question`
                 ;
        ';
        $row = $this->adapter->query($sql)->execute()->current();
        return (int) $row['count'];
    }

    public function selectOrderByCreatedDesc() : Generator
    {
        $sql = '
            SELECT `question`.`question_id`
                 , `question`.`user_id`
                 , `question`.`name`
                 , `question`.`subject`
                 , `question`.`message`
                 , `question`.`created`
                 , `question`.`views`
              FROM `question`
             ORDER
                BY `question`.`created` DESC
             LIMIT 100
                 ;
        ';
        foreach ($this->adapter->query($sql)->execute() as $row) {
            yield($row);
        }
    }

    /**
     * Select where question ID.
     *
     * @param int $questionId
     * @return array
     */
    public function selectWhereQuestionId(int $questionId) : array
    {
        $sql = '
            SELECT `question`.`question_id`
                 , `question`.`user_id`
                 , `question`.`name`
                 , `question`.`subject`
                 , `question`.`message`
                 , `question`.`created`
                 , `question`.`views`
              FROM `question`
             WHERE `question`.`question_id` = :questionId
             ORDER
                BY `question`.`created` ASC
                 ;
        ';
        $parameters = [
            'questionId' => $questionId,
        ];
        return $this->adapter->query($sql)->execute($parameters)->current();
    }

    public function updateViewsWhereQuestionId(int $questionId) : bool
    {
        $sql = '
            UPDATE `question`
               SET `question`.`views` = `question`.`views` + 1
             WHERE `question`.`question_id` = :questionId
                 ;
        ';
        $parameters = [
            'questionId' => $questionId,
        ];
        return (bool) $this->adapter->query($sql, $parameters)->getAffectedRows();
    }
}
