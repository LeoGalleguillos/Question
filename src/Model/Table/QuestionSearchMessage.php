<?php
namespace LeoGalleguillos\Question\Model\Table;

use LeoGalleguillos\Memcached\Model\Service as MemcachedService;
use Zend\Db\Adapter\Adapter;

class QuestionSearchMessage
{
    public function __construct(
        MemcachedService\Memcached $memcachedService,
        Adapter $adapter
    ) {
        $this->memcachedService = $memcachedService;
        $this->adapter   = $adapter;
    }

    public function selectQuestionIdWhereMatchAgainst(
        string $query,
        int $offset,
        int $rowCount = 100
    ): array {
        $cacheKey = md5(__METHOD__ . $query . $offset . $rowCount);
        if (null !== ($questionIds = $this->memcachedService->get($cacheKey))) {
            return $questionIds;
        }

        $sql = "
            SELECT `question_id`,
                    MATCH (`message`) AGAINST (:query) AS `score`
              FROM `question_search_message`
             WHERE MATCH (`message`) AGAINST (:query)
             ORDER
                BY `score` DESC
             LIMIT $offset, $rowCount
                 ;
        ";
        $parameters = [
            'query' => $query,
        ];
        $result = $this->adapter->query($sql)->execute($parameters);

        $questionIds = [];
        foreach ($result as $row) {
            $questionIds[] = $row['id_delete'];
        }

        $this->memcachedService->setForDays($cacheKey, $questionIds, 28);
        return $questionIds;
    }

    public function selectCountWhereMatchAgainst(string $query): int
    {
        $cacheKey = md5(__METHOD__ . $query);
        if (null !== ($count = $this->memcachedService->get($cacheKey))) {
            return $count;
        }

        $sql = '
            SELECT COUNT(*) AS `count`
              FROM `question_search_message`
             WHERE MATCH (`message`) AGAINST (?)
                 ;
        ';
        $row = $this->adapter->query($sql)->execute([$query])->current();

        $count = (int) $row['count'];
        $this->memcachedService->setForDays($cacheKey, $count, 28);
        return (int) $row['count'];
    }
}
