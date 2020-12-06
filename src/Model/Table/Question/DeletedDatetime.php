<?php
namespace LeoGalleguillos\Question\Model\Table\Question;

use Generator;
use MonthlyBasis\Memcached\Model\Service as MemcachedService;
use LeoGalleguillos\Question\Model\Table as QuestionTable;
use Laminas\Db\Adapter\Adapter;

class DeletedDatetime
{
    /**
     * @var Adapter
     */
    protected $adapter;

    public function __construct(
        Adapter $adapter,
        MemcachedService\Memcached $memcachedService,
        QuestionTable\Question $questionTable
    ) {
        $this->adapter          = $adapter;
        $this->memcachedService = $memcachedService;
        $this->questionTable    = $questionTable;
    }

    public function selectCountWhereDeletedDatetimeIsNull(): int
    {
        $cacheKey = md5(__METHOD__);
        if (null !== ($count = $this->memcachedService->get($cacheKey))) {
            return $count;
        }

        $sql = '
            SELECT COUNT(*) AS `count`
              FROM `question`
             WHERE `deleted_datetime` IS NULL
                 ;
        ';
        $count = (int) $this->adapter->query($sql)->execute()->current()['count'];

        $this->memcachedService->setForDays($cacheKey, $count, 7);
        return $count;
    }

    public function selectWhereDeletedDatetimeIsNotNull(
        int $limitRowCount
    ): Generator {
        $sql = $this->questionTable->getSelect()
             . "
              FROM `question`
             WHERE `question`.`deleted_datetime` IS NOT NULL
             ORDER
                BY `question`.`deleted_datetime` DESC
             LIMIT $limitRowCount
                 ;
        ";
        foreach ($this->adapter->query($sql)->execute() as $array) {
            yield $array;
        }
    }
}
