<?php
namespace PHPUnit\PhpDatabaseAnalyzer\Logger;

/**
 * Check test case.
 */
class GetQualityScoreTest extends \PHPUnit_Framework_TestCase
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
        
        $loggingMode = "issues";
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
     * Tests Logger->getQualityScore()
     * @test
     */
    public function getQualityScoreNoIssues()
    {
        $this->assertEquals(0, $this->Logger->getQualityScore());
    }
    
    /**
     * Tests Logger->getQualityScore()
     * @test
     */
    public function getQualityScore()
    {
        $this->Logger->setIssue('notice', 'test', 1);
        $this->Logger->setIssue('notice', 'test', 1);
        $this->Logger->setIssue('notice', 'test', 1);
        
        $this->Logger->setIssue('warning', 'test', 3);
        $this->Logger->setIssue('warning', 'test', 3);
        
        $this->Logger->setIssue('critical', 'test', 2);
        $this->Logger->setIssue('critical', 'test', 5);
        $this->Logger->setIssue('critical', 'test', 9);
        
        $this->assertEquals(193, $this->Logger->getQualityScore());
    }    
}
