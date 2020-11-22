<?php
namespace LeoGalleguillos\Question\Model\Table\Answer;

use Laminas\Db\Adapter\Adapter;

class CreatedIpCreatedDatetime
{
    /**
     * @var Adapter
     */
    protected $adapter;

    public function __construct(Adapter $adapter)
    {
        $this->adapter = $adapter;
    }

    public function selectCountWhereCreatedIpAndCreatedDatetimeGreaterThan(
        string $createdIp,
        string $createdDatetime
    ): int {
        $sql = '
            SELECT COUNT(*) as `count`
              FROM `answer`
             WHERE `answer`.`created_ip` = ?
               AND `answer`.`created_datetime` > ?
                 ;
        ';
        $parameters = [
            $createdIp,
            $createdDatetime,
        ];
        $array = $this->adapter->query($sql)->execute($parameters)->current();
        return (int) $array['count'];
    }
}
