<?php
namespace LeoGalleguillos\Question\Model\Table\Question;

use Generator;
use Zend\Db\Adapter\Adapter;

class Message
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
     * @yield array
     */
    public function selectWhereMessageLikeWildcard(
        string $message,
        int $limitOffset,
        int $limitRowCount
    ): Generator {
        $sql = '
            SELECT `question`.`question_id`
                 , `question`.`user_id`
                 , `question`.`name`
                 , `question`.`subject`
                 , `question`.`message`
                 , `question`.`created`
                 , `question`.`views`
              FROM `question`
             WHERE `question`.`message` LIKE CONCAT(\'%\', ?, \'%\')
             LIMIT 100
        ';
        $parameters = [
            $message,
        ];
        foreach ($this->adapter->query($sql)->execute($parameters) as $array) {
            yield $array;
        }
    }
}
