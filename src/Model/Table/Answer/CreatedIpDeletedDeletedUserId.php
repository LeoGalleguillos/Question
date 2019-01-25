<?php
namespace LeoGalleguillos\Question\Model\Table\Answer;

use Generator;
use Zend\Db\Adapter\Adapter;

class CreatedIpDeletedDeletedUserId
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
              FROM `answer`
             WHERE created_ip = ?
               AND deleted > utc_timestamp() - INTERVAL 1 DAY
               AND deleted_user_id = 0
                 ;
        ';
        $parameters = [
            $createdIp,
        ];
        $array = $this->adapter->query($sql)->execute($parameters);
        return (int) $array['count'];
    }
}
