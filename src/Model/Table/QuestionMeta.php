<?php
namespace LeoGalleguillos\Question\Model\Table;

use Zend\Db\Adapter\Adapter;

class QuestionMeta
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
        int $questionId,
        array $array
    ): int {
        $sql = '
            INSERT
              INTO `question_meta`
                   (`question_id`, `name`)
            VALUES (?, ?)
                 ;
        ';
        $parameters = [
            $questionId,
            $array['name'],
        ];
        return (int) $this->adapter
                          ->query($sql)
                          ->execute($parameters)
                          ->getGeneratedValue();
    }
}
