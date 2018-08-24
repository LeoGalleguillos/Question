<?php
namespace LeoGalleguillos\Question\Model\Table;

use Zend\Db\Adapter\Adapter;

class AnswerMeta
{
    /**
     * @var Adapter
     */
    protected $adapter;

    public function __construct(Adapter $adapter)
    {
        $this->adapter = $adapter;
    }

    public function insert(
        int $answerId,
        array $array
    ): int {
        $sql = '
            INSERT
              INTO `answer_meta`
                   (`answer_id`, `name`)
            VALUES (?, ?)
                 ;
        ';
        $parameters = [
            $answerId,
            $array['name'],
        ];
        return (int) $this->adapter
                          ->query($sql)
                          ->execute($parameters)
                          ->getGeneratedValue();
    }
}
