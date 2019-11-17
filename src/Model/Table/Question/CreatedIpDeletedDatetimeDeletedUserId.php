<?php
namespace LeoGalleguillos\Question\Model\Table\Question;

use Generator;
use Zend\Db\Adapter\Adapter;

class CreatedIpDeletedDatetimeDeletedUserId
{
    /**
     * @var Adapter
     */
    protected $adapter;

    public function __construct(
        Adapter $adapter
    ) {
        $this->adapter = $adapter;
    }


    public function selectCountWhereCreatedIpAndDeletedGreaterThanOneDayAgoAndDeletedUserIdEquals0(
        string $createdIp
    ): int {
        $sql = '
            SELECT COUNT(*) AS `count`
              FROM `question`
             WHERE created_ip = ?
               AND `deleted_datetime` > utc_timestamp() - INTERVAL 1 DAY
               AND deleted_user_id = 0
                 ;
        ';
        $parameters = [
            $createdIp,
        ];
        $array = $this->adapter->query($sql)->execute($parameters)->current();
        return (int) $array['count'];
    }
}
