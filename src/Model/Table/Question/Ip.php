<?php
namespace LeoGalleguillos\Question\Model\Table\Question;

use Generator;
use Zend\Db\Adapter\Adapter;

class Ip
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
     * @return bool
     */
    public function selectQuestionIdWhereIpAndNotExistsQuestionHistory(
        string $ip
    ): Generator {
        $sql = '
            SELECT `question`.`question_id`
              FROM `question`
             WHERE `question`.`ip` = ?
               AND NOT EXISTS (
                       SELECT NULL
                         FROM `question_history`
                        WHERE `question_history`.`question_id` = `question`.`question_id`
                   )
             ORDER
                BY `question`.`created` DESC
             LIMIT 100
                 ;
        ';
        $parameters = [
            $ip,
        ];
        foreach ($this->adapter->query($sql)->execute($parameters) as $array) {
            yield $array['question_id'];
        }
    }
}
