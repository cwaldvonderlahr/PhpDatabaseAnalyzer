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
     * Tests Logger->getQualityScore()
     * @test
     */
    public function getQualityScore()
    {
        /* @todo complete PHPUnit Test */
        $this->markTestIncomplete("Construct test not implemented");

        $this->Logger->getQualityScore(/* parameters */);
    }
}
