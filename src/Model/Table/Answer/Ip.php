<?php
namespace LeoGalleguillos\Question\Model\Table\Answer;

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
    public function selectAnswerIdWhereIpAndNotExistsAnswerHistory(
        string $ip
    ): Generator {
        $sql = '
            SELECT `answer`.`answer_id`
              FROM `answer`
             WHERE `answer`.`ip` = ?
               AND NOT EXISTS (
                       SELECT NULL
                         FROM `answer_history`
                        WHERE `answer_history`.`answer_id` = `answer`.`answer_id`
                   )
             LIMIT 100
                 ;
        ';
        $parameters = [
            $ip,
        ];
        foreach ($this->adapter->query($sql)->execute($parameters) as $array) {
            yield $array['answer_id'];
        }
    }
}
