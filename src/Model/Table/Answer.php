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
     * @return int
     */
    public function insert(
        int $questionId,
        int $userId = null,
        string $message
    ) : int {
        $sql = '
            INSERT
              INTO `answer` (
                   `question_id`, `user_id`, `message`, `created`
                   )
            VALUES (:questionId, :userId, :message, UTC_TIMESTAMP())
                 ;
        ';
        $parameters = [
            'questionId' => $questionId,
            'userId'     => $userId,
            'message'    => $message,
        ];
        return $this->adapter
                    ->query($sql)
                    ->execute($parameters)
                    ->getGeneratedValue();
    }

    public function selectCount()
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
                 , `answer`.`message`
                 , `answer`.`created`
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
}
