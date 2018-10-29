<?php
namespace LeoGalleguillos\Question\Model\Table;

use Zend\Db\Adapter\Adapter;

class QuestionBrowserLog
{
    /**
     * @var Adapter
     */
    protected $adapter;

    /**
     * Construct.
     *
     * @param Adapter $adapter
     */
    public function __construct(Adapter $adapter)
    {
        $this->adapter = $adapter;
    }

    public function insert(
        int $questionId,
        string $ip,
        string $httpUserAgent
    ): int {
        $sql = '
            INSERT
              INTO `question_browser_log` (
                       `question_id`
                     , `ip`
                     , `http_user_agent`
                     , `created`
                   )
            VALUES (?, ?, ?, UTC_TIMESTAMP())
                 ;
        ';
        $parameters = [
            $questionId,
            $ip,
            $httpUserAgent,
        ];
        return $this->adapter
                    ->query($sql)
                    ->execute($parameters)
                    ->getGeneratedValue();
    }
}
