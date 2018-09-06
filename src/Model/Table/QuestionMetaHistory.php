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

    public function insertSelectFromQuestionMeta(
        int $questionMetaId
    ): int {
        $sql = '
            INSERT
              INTO `question_meta_history`
                   (`question_meta_id`, `name`)
            SELECT `question_meta`.`question_meta_id`
                 , `question_meta`.`name`
              FROM `question_meta`
             WHERE `question_meta`.`question_meta_id` = ?
        ';
        $parameters = [
            $questionMetaId,
        ];
        return (int) $this->adapter
                          ->query($sql)
                          ->execute($parameters)
                          ->getGeneratedValue();
    }
}
