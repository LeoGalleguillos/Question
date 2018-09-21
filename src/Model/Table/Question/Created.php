<?php
namespace LeoGalleguillos\Question\Model\Table\Question;

use Generator;
use Zend\Db\Adapter\Adapter;

class Created
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

    /**
     * Select where created is greater than or equal to and less than.
     *
     * @param string $createdMin
     * @param string $createdMax
     * @return Generator
     * @yield array
     */
    public function selectWhereCreatedGreaterThanOrEqualToAndLessThan(
        string $createdMin,
        string $createdMax
    ): Generator {
        $sql = '
            SELECT `question`.`question_id`
                 , `question`.`user_id`
                 , `question`.`name`
                 , `question`.`subject`
                 , `question`.`message`
                 , `question`.`views`
                 , `question`.`created`
                 , `question`.`deleted`
              FROM `question`
             WHERE `question`.`created` >= ?
               AND `question`.`created` < ?
                 ;
        ';
        $parameters = [
            $createdMin,
            $createdMax,
        ];
        foreach ($this->adapter->query($sql)->execute($parameters) as $array) {
            yield $array;
        }
    }
}
