<?php
namespace LeoGalleguillos\Question\Model\Table;

use Exception;
use Generator;
use Zend\Db\Adapter\Adapter;

class Answer
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
     * Insert into `answer` table.
     *
     * @param int $questionId
     * @param int|null $userId
     * @param string|null $name
     * @param string $message
     * @return int
     */
    public function insert(
        int $questionId,
        int $userId = null,
        string $name = null,
        string $message
    ): int {
        $sql = '
            INSERT
              INTO `answer` (
                   `question_id`, `user_id`, `name`, `message`, `created`
                   )
            VALUES (?, ?, ?, ?, UTC_TIMESTAMP())
                 ;
        ';
        $parameters = [
            $questionId,
            $userId,
            $name,
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
    public function insertAnswerIdQuestionIdNameMessageIp(
        int $answerId,
        int $questionId,
        string $name,
        string $message,
        string $ip
    ): int {
        $sql = '
            INSERT
              INTO `answer` (
                       `answer_id`, `question_id`, `name`, `message`, `ip`, `created`
                   )
            VALUES (?, ?, ?, ?, ?, UTC_TIMESTAMP())
                 ;
        ';
        $parameters = [
            $answerId,
            $questionId,
            $name,
            $message,
            $ip,
        ];
        return (int) $this->adapter
                          ->query($sql)
                          ->execute($parameters)
                          ->getGeneratedValue();
    }

    /**
     * @return int
     */
    public function insertAnswerIdQuestionIdNameMessageIpCreatedNameCreatedIp(
        int $answerId,
        int $questionId,
        string $name,
        string $message,
        string $ip,
        string $createdName,
        string $createdIp
    ): int {
        $sql = '
            INSERT
              INTO `answer` (
                      `answer_id`
                    , `question_id`
                    , `name`
                    , `message`
                    , `ip`
                    , `created`
                    , `created_datetime`
                    , `created_name`
                    , `created_ip`
                   )
            VALUES (?, ?, ?, ?, ?, UTC_TIMESTAMP(), UTC_TIMESTAMP(), ?, ?)
                 ;
        ';
        $parameters = [
            $answerId,
            $questionId,
            $name,
            $message,
            $ip,
            $createdName,
            $createdIp,
        ];
        return (int) $this->adapter
                          ->query($sql)
                          ->execute($parameters)
                          ->getGeneratedValue();
    }

    /**
     * Select count.
     *
     * @return int
     */
    public function selectCount(): int
    {
        $sql = '
            SELECT COUNT(*) AS `count`
              FROM `answer`
                 ;
        ';
        $row = $this->adapter->query($sql)->execute()->current();
        return (int) $row['count'];
    }

    /**
     * Select count where question ID.
     *
     * @param int $questionId
     * @return int
     */
    public function selectCountWhereQuestionId(int $questionId): int
    {
        $sql = '
            SELECT COUNT(*) AS `count`
              FROM `answer`
             WHERE `question_id` = ?
                 ;
        ';
        $row = $this->adapter->query($sql)->execute([$questionId])->current();
        return (int) $row['count'];
    }

    /**
     * Select where answer ID.
     *
     * @param int $answerId
     * @return array
     */
    public function selectWhereAnswerId(int $answerId) : array
    {
        $sql = '
            SELECT `answer`.`answer_id`
                 , `answer`.`question_id`
                 , `answer`.`user_id`
                 , `answer`.`name`
                 , `answer`.`message`
                 , `answer`.`ip`
                 , `answer`.`created`
                 , `answer`.`deleted`
              FROM `answer`
             WHERE `answer`.`answer_id` = :answerId
                 ;
        ';
        $parameters = [
            'answerId' => $answerId,
        ];
        return $this->adapter->query($sql)->execute($parameters)->current();
    }

    /**
     * Select where question ID.
     *
     * @param int $questionId
     * @return Generator
     */
    public function selectWhereQuestionId(int $questionId) : Generator
    {
        $sql = '
            SELECT `answer`.`answer_id`
                 , `answer`.`question_id`
                 , `answer`.`user_id`
                 , `answer`.`name`
                 , `answer`.`message`
                 , `answer`.`ip`
                 , `answer`.`created`
                 , `answer`.`deleted`
              FROM `answer`
             WHERE `answer`.`question_id` = :questionId
             ORDER
                BY `answer`.`created` ASC
                 ;
        ';
        $parameters = [
            'questionId' => $questionId,
        ];
        foreach ($this->adapter->query($sql)->execute($parameters) as $array) {
            yield $array;
        }
    }

    public function updateWhereAnswerId(
        int $userId,
        string $name = null,
        string $message,
        string $ip,
        int $answerId
    ): bool {
        $sql = '
            UPDATE `answer`
               SET `answer`.`user_id` = ?
                 , `answer`.`name` = ?
                 , `answer`.`message` = ?
                 , `answer`.`ip` = ?
                 , `answer`.`created` = UTC_TIMESTAMP()
             WHERE `answer`.`answer_id` = ?
                 ;
        ';
        $parameters = [
            $userId,
            $name,
            $message,
            $ip,
            $answerId,
        ];
        return (bool) $this->adapter
                           ->query($sql)
                           ->execute($parameters)
                           ->getAffectedRows();
    }
}
