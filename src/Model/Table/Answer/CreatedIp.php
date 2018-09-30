<?php
namespace LeoGalleguillos\Question\Model\Table\Answer;

use Generator;
use Zend\Db\Adapter\Adapter;

class CreatedIp
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
     */
    public function selectAnswerIdWhereCreatedIp(
        string $createdIp
    ): Generator {
        $sql = '
            SELECT `answer`.`answer_id`
              FROM `answer`
             WHERE `answer`.`created_ip` = ?
             ORDER
                BY `answer`.`created_datetime` DESC
             LIMIT 100
                 ;
        ';
        $parameters = [
            $createdIp,
        ];
        foreach ($this->adapter->query($sql)->execute($parameters) as $array) {
            yield $array['question_id'];
        }
    }
}
