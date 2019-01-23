<?php
namespace LeoGalleguillos\Question\Model\Table\Question;

use Zend\Db\Adapter\Adapter;

class QuestionId
{
    /**
     * @var Adapter
     */
    protected $adapter;

    public function __construct(Adapter $adapter)
    {
        $this->adapter = $adapter;
    }

    public function updateIncrementViewsBrowserWhereQuestionId(
        int $questionId
    ): int {
        $sql = '
            UPDATE `question`
               SET `question`.`views_browser` = `question`.`views_browser` + 1
             WHERE `question`.`question_id` = ?
                 ;
        ';
        $parameters = [
            $questionId,
        ];
        return (int) $this->adapter
            ->query($sql)
            ->execute($parameters)
            ->getAffectedRows();
    }

    public function updateSetViewsBrowserWhereQuestionId(
        int $viewsBrowser,
        int $questionId
    ): int {
        $sql = '
            UPDATE `question`
               SET `question`.`views_browser` = ?
             WHERE `question`.`question_id` = ?
                 ;
        ';
        $parameters = [
            $viewsBrowser,
            $questionId,
        ];
        return (int) $this->adapter
            ->query($sql)
            ->execute($parameters)
            ->getAffectedRows();
    }
}
