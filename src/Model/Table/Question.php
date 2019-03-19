<?php
namespace LeoGalleguillos\Question\Model\Table;

use Generator;
use LeoGalleguillos\Memcached\Model\Service as MemcachedService;
use Zend\Db\Adapter\Adapter;

class Question
{
    /**
     * @var Adapter
     */
    protected $adapter;

    public function __construct(
        Adapter $adapter,
        MemcachedService\Memcached $memcachedService
    ) {
        $this->adapter          = $adapter;
        $this->memcachedService = $memcachedService;
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
                 , `question`.`views_browser`
                 , `question`.`created`
                 , `question`.`created_datetime`
                 , `question`.`created_name`
                 , `question`.`created_ip`
                 , `question`.`deleted`
                 , `question`.`deleted_user_id`
                 , `question`.`deleted_reason`
        ';
    }

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

    public function insertDeleted(
        int $userId = null,
        string $name,
        string $subject,
        string $message,
        string $ip,
        string $createdName,
        string $createdIp,
        string $deletedUserId,
        string $deletedReason
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
                     , `deleted`
                     , `deleted_user_id`
                     , `deleted_reason`
                   )
            VALUES (?, ?, ?, ?, ?, UTC_TIMESTAMP(), UTC_TIMESTAMP(), ?, ?, UTC_TIMESTAMP(), ?, ?)
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
            $deletedUserId,
            $deletedReason,
        ];
        return (int) $this->adapter
                          ->query($sql)
                          ->execute($parameters)
                          ->getGeneratedValue();
    }

    public function selectCount(): int
    {
        $cacheKey = md5(__METHOD__);
        if (null !== ($count = $this->memcachedService->get($cacheKey))) {
            return $count;
        }

        $sql = '
            SELECT COUNT(*) AS `count`
              FROM `question`
                 ;
        ';
        $count = (int) $this->adapter->query($sql)->execute()->current()['count'];

        $this->memcachedService->setForDays($cacheKey, $count, 7);
        return $count;
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
        string $name = null,
        string $subject,
        string $message,
        int $modifiedUserId,
        int $questionId
    ): bool {
        $sql = '
            UPDATE `question`
               SET `question`.`name` = ?
                 , `question`.`subject` = ?
                 , `question`.`message` = ?
                 , `question`.`modified_datetime` = UTC_TIMESTAMP()
                 , `question`.`modified_user_id` = ?
             WHERE `question`.`question_id` = ?
                 ;
        ';
        $parameters = [
            $name,
            $subject,
            $message,
            $modifiedUserId,
            $questionId,
        ];
        return (bool) $this->adapter
                           ->query($sql)
                           ->execute($parameters)
                           ->getAffectedRows();
    }
}
