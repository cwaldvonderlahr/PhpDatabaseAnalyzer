<?php
namespace PHPUnit\PhpDatabaseAnalyzer\Logger;

/**
 * Check test case.
 */
class SetIssueTest extends \PHPUnit_Framework_TestCase
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
     * Tests Logger->setIssues()
     * @test
     */
    public function setIssuesInvalidType()
    {
        $type = "note";
        $text = "Hallo Welt";
        $scorePoints = 1;
        $this->assertFalse($this->Logger->setIssue($type, $text, $scorePoints));
        
        $log = $this->Logger->getLog();
        
        $this->assertEquals(0, count($log));
    }
    
    /**
     * Tests Logger->setIssues()
     * @test
     */
    public function setIssuesEmptyText()
    {
        $type = "notice";
        $text = "";
        $scorePoints = 1;
        $this->assertFalse($this->Logger->setIssue($type, $text, $scorePoints));
    
        $log = $this->Logger->getLog();
    
        $this->assertEquals(0, count($log));
    }    
    
    /**
     * Tests Logger->setIssues()
     * @test
     */
    public function setIssuesInvalidScorePoints()
    {
        $type = "notice";
        $text = "Hallo Welt";
        $scorePoints = 'aa';
        $this->assertFalse($this->Logger->setIssue($type, $text, $scorePoints));
    
        $log = $this->Logger->getLog();
    
        $this->assertEquals(0, count($log));
    }    
    
    /**
     * Tests Logger->setIssues()
     * @test
     */
    public function setIssuesNegativeScorePoints()
    {
        $type = "notice";
        $text = "Hallo Welt";
        $scorePoints = -1;
        $this->assertFalse($this->Logger->setIssue($type, $text, $scorePoints));
    
        $log = $this->Logger->getLog();
    
        $this->assertEquals(0, count($log));
    }    
    
    /**
     * Tests Logger->setIssues()
     * @test
     */
    public function setIssuesSetNotice()
    {
        $type = "notice";
        $text = "Hallo Welt";
        $scorePoints = 2;
        $this->assertTrue($this->Logger->setIssue($type, $text, $scorePoints));
    
        $log = $this->Logger->getLog();
    
        $this->assertEquals(1, count($log));
        
        $this->assertEquals("issue", $log[0]['logType']);
        $this->assertEquals(2, $log[0]['scorePoints']);
        $this->assertEquals("notice", $log[0]['issueType']);
    } 
    
    /**
     * Tests Logger->setIssues()
     * @test
     */
    public function setIssuesSetWarning()
    {
        $type = "warning";
        $text = "Hallo Welt";
        $scorePoints = 9;
        $this->assertTrue($this->Logger->setIssue($type, $text, $scorePoints));
    
        $log = $this->Logger->getLog();
    
        $this->assertEquals(1, count($log));
    
        $this->assertEquals("issue", $log[0]['logType']);
        $this->assertEquals(9, $log[0]['scorePoints']);
        $this->assertEquals("warning", $log[0]['issueType']);
    }    
    
    /**
     * Tests Logger->setIssues()
     * @test
     */
    public function setIssuesSetCritical()
    {
        $type = "critical";
        $text = "Hallo Welt";
        $scorePoints = 7;
        $this->assertTrue($this->Logger->setIssue($type, $text, $scorePoints));
    
        $log = $this->Logger->getLog();
    
        $this->assertEquals(1, count($log));
    
        $this->assertEquals("issue", $log[0]['logType']);
        $this->assertEquals(7, $log[0]['scorePoints']);
        $this->assertEquals("critical", $log[0]['issueType']);
    }    
}
