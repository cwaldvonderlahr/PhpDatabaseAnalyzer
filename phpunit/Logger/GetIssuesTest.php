<?php
namespace PHPUnit\PhpDatabaseAnalyzer\Logger;

/**
 * Check test case.
 */
class GetIssuesTest extends \PHPUnit_Framework_TestCase
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
     * Tests Logger->getIssuses()
     * @test
     */
    public function getIssuesNoLogEntries()
    {
        $issues = $this->Logger->getIssues();
        
        $this->assertTrue(is_array($issues));
        $this->assertEquals(0, count($issues));
    }

    /**
     * Tests Logger->getIssuses()
     * @test
     */
    public function getIssuesOnlyInfos()
    {
        $this->Logger->setInfo('Start');
        $this->Logger->setInfo('Database');
        $this->Logger->setInfo('End');
        
        $issues = $this->Logger->getIssues();
        
        $this->assertTrue(is_array($issues));
        $this->assertEquals(0, count($issues));
    }

    /**
     * Tests Logger->getIssuses()
     * @test
     */
    public function getIssuesOnlyOneIssue()
    {
        $this->Logger->setInfo('Start');
        $this->Logger->setInfo('Database');
        $this->Logger->setIssue('critical', 'error', 6);
        $this->Logger->setInfo('End');
        
        $issues = $this->Logger->getIssues();
        
        $this->assertTrue(is_array($issues));
        $this->assertEquals(1, count($issues));
        
        foreach ($issues as $issueKey => $issueEntry) {
            $this->assertTrue(is_int($issueKey));
            
            $this->assertTrue(is_array($issueEntry));
            
            $this->assertEquals(4, count($issueEntry));
            
            $this->assertEquals(6, $issueEntry['scorePoints']);
            $this->assertEquals('critical', $issueEntry['issueType']);
            
            $this->assertNotFalse(date("Y-m-d", $issueEntry['timestamp']));
            
            $this->assertNotEmpty($issueEntry['text']);
            $this->assertTrue(is_string($issueEntry['text']));
        }
    }
    
    /**
     * Tests Logger->getIssuses()
     * @test
     */
    public function getIssuesMoreIssues()
    {
        $this->Logger->setInfo('Start');
        $this->Logger->setInfo('Database');
        $this->Logger->setIssue('critical', 'error', 6);
        $this->Logger->setIssue('notice', 'line 6', 1);
        $this->Logger->setIssue('critical', 'table', 8);
        $this->Logger->setInfo('End');
    
        $issues = $this->Logger->getIssues();
    
        $this->assertTrue(is_array($issues));
        $this->assertEquals(3, count($issues));
    
        foreach ($issues as $issueKey => $issueEntry) {
            $this->assertTrue(is_int($issueKey));
    
            $this->assertTrue(is_array($issueEntry));
    
            $this->assertEquals(4, count($issueEntry));
    
            $this->assertGreaterThan(0, $issueEntry['scorePoints']);
            $this->assertNotEmpty($issueEntry['issueType']);
    
            $this->assertNotFalse(date("Y-m-d", $issueEntry['timestamp']));
    
            $this->assertNotEmpty($issueEntry['text']);
            $this->assertTrue(is_string($issueEntry['text']));
        }
    }    
}
