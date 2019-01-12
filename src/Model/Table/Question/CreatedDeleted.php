<?php
namespace LeoGalleguillos\Question\Model\Table\Question;

use Generator;
use LeoGalleguillos\Memcached\Model\Service as MemcachedService;
use Zend\Db\Adapter\Adapter;

class CreatedDeleted
{
    /**
     * @var Adapter
     */
    protected $adapter;

    public function __construct(
        Adapter $adapter,
        MemcachedService\Memcached $memcachedService
    ) {
        $this->adapter          = $adapter;
        $this->memcachedService = $memcachedService;
    }


    public function selectQuestionIdWhereCreatedInYearAndDeletedIsNull(int $year): array
    {
        $cacheKey = md5(__METHOD__);
        if (null !== ($questionIds = $this->memcachedService->get($cacheKey))) {
            return $questionIds;
        }

        $sql = '
            SELECT `question_id`
              from question
             where created >= ?
               and created < ?
               AND deleted IS NULL

             ORDER
                BY views DESC

             LIMIT 100
                 ;
        ';
        $parameters = [
            "$year-01-01 05:00:00",
            ($year + 1) . "-01-01 05:00:00",
        ];
        $questionIds = [];
        foreach ($this->adapter->query($sql)->execute($parameters) as $array) {
            $questionIds[] = (int) $array['question_id'];
        }

        $this->memcachedService->setForDays($cacheKey, $questionIds, 14);
        return $questionIds;
    }
}
