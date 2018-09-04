<?php
namespace LeoGalleguillos\Question\Model\Table;

use Zend\Db\Adapter\Adapter;

class QuestionMetaHistory
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
        array $array
    ): int {
        $sql = '
            INSERT
              INTO `question_meta_history_id`
                   (`name`)
            VALUES (?)
                 ;
        ';
        $parameters = [
            $array['name'],
        ];
        return (int) $this->adapter
                          ->query($sql)
                          ->execute($parameters)
                          ->getGeneratedValue();
    }
}
