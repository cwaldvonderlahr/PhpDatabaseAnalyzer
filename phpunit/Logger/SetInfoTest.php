<?php
namespace PHPUnit\PhpDatabaseAnalyzer\Logger;

/**
 * Check test case.
 */
class SetInfoTest extends \PHPUnit\Framework\TestCase
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
     * Tests Logger->setInfo()
     * @test
     */
    public function setInfoWithFullLogging()
    {
        $loggingMode = "full";
        $this->Logger = new \PhpDatabaseAnalyzer\Logger($loggingMode);

        $text = "Hello World";
        $this->assertTrue($this->Logger->setInfo($text));

        $log = $this->Logger->getLog();

        $this->assertEquals(1, count($log));

        $this->assertEquals($text, $log[0]['text']);
    }

    /**
     * Tests Logger->setInfo()
     * @test
     */
    public function setInfoWithIssueLogging()
    {
        $loggingMode = "issues";
        $this->Logger = new \PhpDatabaseAnalyzer\Logger($loggingMode);

        $text = "Hello World";
        $this->assertFalse($this->Logger->setInfo($text));

        $log = $this->Logger->getLog();

        $this->assertEquals(0, count($log));
    }

    /**
     * Tests Logger->setInfo()
     * @test
     */
    public function setInfoWithEmptyText()
    {
        $loggingMode = "full";
        $this->Logger = new \PhpDatabaseAnalyzer\Logger($loggingMode);

        $text = "";
        $this->assertFalse($this->Logger->setInfo($text));

        $log = $this->Logger->getLog();

        $this->assertEquals(0, count($log));
    }

    /**
     * Tests Logger->setInfo()
     * @test
     */
    public function setInfoWithNoneStringText()
    {
        $loggingMode = "full";
        $this->Logger = new \PhpDatabaseAnalyzer\Logger($loggingMode);

        $text = array();
        $this->assertFalse($this->Logger->setInfo($text));

        $log = $this->Logger->getLog();

        $this->assertEquals(0, count($log));
    }
}
