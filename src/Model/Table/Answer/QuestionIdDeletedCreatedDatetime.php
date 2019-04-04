<?php
namespace LeoGalleguillos\Question\Model\Table\Answer;

use DateTime;
use Zend\Db\Adapter\Adapter;

class QuestionIdDeletedCreatedDatetime
{
    /**
     * @var Adapter
     */
    protected $adapter;

    public function __construct(Adapter $adapter)
    {
        $this->adapter = $adapter;
    }

    public function selectCountWhereQuestionIdCreatedDatetimeGreaterThanAndMessageEquals(
        int $questionId,
        DateTime $createdDateTime,
        string $message
    ): int {
        $sql = '
            SELECT COUNT(*) AS `count`
              FROM `answer`
             WHERE `answer`.`question_id` = ?
               AND `answer`.`created_datetime` > ?
               AND `answer`.`message` = ?
        ';
        $parameters = [
            $questionId,
            $createdDateTime->format('Y-m-d H:i:s'),
            $message,
        ];
        $array = $this->adapter->query($sql)->execute($parameters)->current();
        return (int) $array['count'];
    }
}
