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
     * @param int $questionId
     * @param int|null $userId
     * @param string $message
     * @return int
     */
    public function insert(
        int $questionId,
        int $userId = null,
        string $name = null,
        string $message
    ) : int {
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
                 , `answer`.`created`
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
