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

    /**
     * Construct.
     *
     * @param Adapter $adapter
     */
    public function __construct(Adapter $adapter)
    {
        $this->adapter = $adapter;
    }

    /**
     * Get select.
     *
     * @return string
     */
    public function getSelect(): string
    {
        return '
            SELECT `question`.`question_id`
                 , `question`.`user_id`
                 , `question`.`name`
                 , `question`.`subject`
                 , `question`.`message`
                 , `question`.`ip`
                 , `question`.`views`
                 , `question`.`created`
                 , `question`.`created_datetime`
                 , `question`.`created_name`
                 , `question`.`created_ip`
                 , `question`.`deleted`
        ';
    }

    /**
     * Insert.
     *
     * @param int|null $userId
     * @param string|null $name
     * @param string $subject
     * @param string|null $message
     * @return int
     */
    public function insert(
        int $userId = null,
        string $name = null,
        string $subject,
        string $message = null,
        string $ip,
        string $createdName = null,
        string $createdIp
    ): int {
        $sql = '
            INSERT
              INTO `question` (
                       `user_id`
                     , `name`
                     , `subject`
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
            $userId,
            $name,
            $subject,
            $message,
            $ip,
            $createdName,
            $createdIp,
        ];
        return $this->adapter
                    ->query($sql)
                    ->execute($parameters)
                    ->getGeneratedValue();
    }

    /**
     * Insert question ID, name, subject, message, IP, created name, and created IP.
     *
     * @param int $questionId
     * @param string $name
     * @param string $subject
     * @param string $message
     * @param string $ip
     * @param string $createdName
     * @param string $createdIp
     * @return int
     */
    public function insertQuestionIdNameSubjectMessageIpCreatedNameCreatedIp(
        int $questionId,
        string $name,
        string $subject,
        string $message,
        string $ip,
        string $createdName,
        string $createdIp
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
                     , `created_datetime`
                     , `created_name`
                     , `created_ip`
                   )
            VALUES (?, ?, ?, ?, ?, UTC_TIMESTAMP(), UTC_TIMESTAMP(), ?, ?)
                 ;
        ';
        $parameters = [
            $questionId,
            $name,
            $subject,
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
     */
    public function selectCount(): int
    {
        $sql = '
            SELECT COUNT(*) AS `count`
              FROM `question`
                 ;
        ';
        $row = $this->adapter->query($sql)->execute()->current();
        return (int) $row['count'];
    }

    /**
     * Select where deleted is null order by created_datetime desc.
     *
     * @param int $limitOffset
     * @param int $limitRowCount
     * @return Generator
     */
    public function selectWhereDeletedIsNullOrderByCreatedDateTimeDesc(
        int $limitOffset,
        int $limitRowCount
    ): Generator {
        $sql = $this->getSelect()
             . "
              FROM `question`
             WHERE `deleted` IS NULL
             ORDER
                BY `question`.`created_datetime` DESC
             LIMIT $limitOffset, $limitRowCount
                 ;
        ";
        foreach ($this->adapter->query($sql)->execute() as $array) {
            yield($array);
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
        $sql = $this->getSelect()
             . '
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

    public function selectWhereQuestionIdInAndDeletedIsNull(
        array $questionIds
    ): Generator {
        $questionIds = array_map('intval', $questionIds);
        $questionIds = implode(', ', $questionIds);

        $sql = $this->getSelect()
             . "
              FROM `question`
             WHERE `question`.`question_id` IN ($questionIds)
               AND `question`.`deleted` IS NULL
             ORDER
                BY FIELD(`question`.`question_id`, $questionIds)

                 ;
        ";
        foreach ($this->adapter->query($sql)->execute() as $array) {
            yield $array;
        }
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

    public function updateWhereQuestionId(
        int $userId,
        string $name = null,
        string $subject,
        string $message,
        string $ip,
        int $questionId
    ): bool {
        $sql = '
            UPDATE `question`
               SET `question`.`user_id` = ?
                 , `question`.`name` = ?
                 , `question`.`subject` = ?
                 , `question`.`message` = ?
                 , `question`.`ip` = ?
                 , `question`.`created` = UTC_TIMESTAMP()
             WHERE `question`.`question_id` = ?
                 ;
        ';
        $parameters = [
            $userId,
            $name,
            $subject,
            $message,
            $ip,
            $questionId,
        ];
        return (bool) $this->adapter
                           ->query($sql)
                           ->execute($parameters)
                           ->getAffectedRows();
    }
}
