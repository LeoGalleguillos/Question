<?php
namespace LeoGalleguillos\Question\Model\Table\Question;

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

    public function selectQuestionIdWhereCreatedIp(
        string $createdIp
    ): Generator {
        $sql = '
            SELECT `question`.`question_id`
              FROM `question`
             WHERE `question`.`created_ip` = ?
             ORDER
                BY `question`.`created_datetime` DESC
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
