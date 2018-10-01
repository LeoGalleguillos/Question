<?php
namespace LeoGalleguillos\Question\Model\Table\Question;

use Generator;
use Zend\Db\Adapter\Adapter;

class CreatedName
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
    public function selectWhereCreatedName(
        string $createdName,
        int $limitOffset,
        int $limitRowCount
    ): Generator {
        $sql = "
            SELECT `question`.`question_id`
                 , `question`.`user_id`
                 , `question`.`name`
                 , `question`.`subject`
                 , `question`.`message`
                 , `question`.`ip`
                 , `question`.`views`
                 , `question`.`created`
                 , `question`.`created_datetime`
                 , `question`.`created_name`
                 , `question`.`created_ip`
                 , `question`.`deleted`
              FROM `question`
             WHERE `question`.`created_name` = ?
               AND `question`.`deleted` = NULL
             ORDER
                BY `question`.`created_datetime` DESC
             LIMIT $limitOffset, $limitRowCount
                 ;
        ";
        $parameters = [
            $createdName,
        ];
        foreach ($this->adapter->query($sql)->execute($parameters) as $array) {
            yield $array;
        }
    }
}
