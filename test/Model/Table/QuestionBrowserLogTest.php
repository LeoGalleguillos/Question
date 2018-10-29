<?php
namespace LeoGalleguillos\QuestionTest\Model\Table;

use LeoGalleguillos\Question\Model\Table as QuestionTable;
use LeoGalleguillos\Test\TableTestCase;

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

    public function testInitialize()
    {
        $this->assertInstanceOf(
            QuestionTable\QuestionBrowserLog::class,
            $this->questionBrowserLogTable
        );
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
}
