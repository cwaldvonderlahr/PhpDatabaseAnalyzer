<?php
namespace PHPUnit\PhpDatabaseAnalyzer\Logger;

/**
 * Check test case.
 */
class GetLogTest extends \PHPUnit_Framework_TestCase
{

    /**
     *
     * @var Logger
     */
    private $Logger;

    /**
     * Prepares the environment before running a test.
     */
    protected function setUp()
    {
        parent::setUp();

        $loggingMode = "full";
        $this->Logger = new \PhpDatabaseAnalyzer\Logger($loggingMode);
    }

    /**
     * Cleans up the environment after running a test.
     */
    protected function tearDown()
    {
        $this->Logger = null;

        parent::tearDown();
    }

    /**
     * Tests Logger->getLog()
     * @test
     */
    public function getLogEmptyLog()
    {
        $log = $this->Logger->getLog();

        $this->assertTrue(is_array($log));
        $this->assertEquals(0, count($log));
    }

    /**
     * Tests Logger->getLog()
     * @test
     */
    public function getLogCheckStructure()
    {
        $this->Logger->setInfo('Start');
        $this->Logger->setInfo('Database');
        $this->Logger->setIssue('notice', 'test', 1);
        $this->Logger->setInfo('End');

        $log = $this->Logger->getLog();

        $this->assertTrue(is_array($log));
        $this->assertEquals(4, count($log));

        foreach ($log as $logKey => $logEntry) {
            $this->assertTrue(is_int($logKey));

            $this->assertTrue(is_array($logEntry));

            if ($logKey == 2) {
                $this->assertEquals(5, count($logEntry));
                $this->assertEquals('issue', $logEntry['logType']);

                $this->assertEquals(1, $logEntry['scorePoints']);
                $this->assertEquals('notice', $logEntry['issueType']);
            } else {
                $this->assertEquals(5, count($logEntry));
                $this->assertEquals('info', $logEntry['logType']);
            }

            $this->assertNotFalse(date("Y-m-d", $logEntry['timestamp']));

            $this->assertNotEmpty($logEntry['text']);
            $this->assertTrue(is_string($logEntry['text']));
        }
    }
}
