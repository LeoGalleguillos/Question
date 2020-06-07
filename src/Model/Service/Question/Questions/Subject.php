<?php
namespace LeoGalleguillos\Question\Model\Service\Question\Questions;

use Generator;
use Laminas\Db as LaminasDb;
use LeoGalleguillos\Question\Model\Factory as QuestionFactory;
use LeoGalleguillos\Question\Model\Table as QuestionTable;

class Subject
{
    public function __construct(
        LaminasDb\Sql\Sql $sql,
        QuestionFactory\Question $questionFactory
    ) {
        $this->questionFactory = $questionFactory;
        $this->sql             = $sql;
    }

    public function getQuestions(
        string $subject,
        int $page
    ): Generator {
        $select = $this->sql
            ->select('question')
            ->columns([
                'question_id',
                'user_id',
                'subject',
                'message',
                'views',
                'created_datetime',
                'created_name',
                'created_ip',
                'modified_user_id',
                'modified_datetime',
                'modified_reason',
                'deleted_datetime',
                'deleted_user_id',
                'deleted_reason',
            ])
            ->where([
                'subject' => $subject,
                'deleted_datetime' => null,
            ])
            ->order('views_not_bot_one_month DESC')
            ->limit(100)
            ->offset(($page - 1) * 100)
            ;
        $result = $this->sql->prepareStatementForSqlObject($select)->execute();

        foreach ($result as $array) {
            yield $this->questionFactory->buildFromArray($array);
        }
    }
}
