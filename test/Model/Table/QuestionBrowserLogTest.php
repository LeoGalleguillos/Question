<?php
namespace LeoGalleguillos\QuestionTest\Model\Table;

use LeoGalleguillos\Question\Model\Table as QuestionTable;
use LeoGalleguillos\Test\TableTestCase;
use TypeError;

class QuestionBrowserLogTest extends TableTestCase
{
    protected function setUp()
    {
        $this->questionBrowserLogTable = new QuestionTable\QuestionBrowserLog(
            $this->getAdapter()
        );

        $this->dropTable('question_browser_log');
        $this->createTable('question_browser_log');
    }

    public function testInsert()
    {
        $questionBrowserLogId = $this->questionBrowserLogTable->insert(
            12345,
            'ip',
            'http_user_agent'
        );
        $this->assertSame(
            1,
            $questionBrowserLogId
        );

        $questionBrowserLogId = $this->questionBrowserLogTable->insert(
            67890,
            'ip',
            'http_user_agent'
        );
        $this->assertSame(
            2,
            $questionBrowserLogId
        );
    }

    public function testSelectQuestionIdCountOrderByCountDescLimit1()
    {
        try {
            $this->questionBrowserLogTable->selectQuestionIdCountOrderByCountDescLimit1();
            $this->fail();
        } catch (TypeError $typeError) {
            $this->assertSame(
                'Return value of',
                substr($typeError->getMessage(), 0, 15)
            );
        }

        $this->questionBrowserLogTable->insert(
            12345,
            'ip',
            'http_user_agent'
        );
        $this->questionBrowserLogTable->insert(
            56789,
            'ip',
            'http_user_agent'
        );
        $this->questionBrowserLogTable->insert(
            12345,
            'ip',
            'http_user_agent'
        );

        $array = $this->questionBrowserLogTable->selectQuestionIdCountOrderByCountDescLimit1();
        $this->assertSame(
            [
                'question_id' => '12345',
                'count'       => '2',
            ],
            $array
        );
    }
}
