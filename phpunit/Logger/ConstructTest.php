<?php
namespace PHPUnit\PHPDatabaseAnalyzer\Logger;

/**
 * Check test case.
 */
class ConstructTest extends \PHPUnit_Framework_TestCase
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
        $this->Logger = new \PHPDatabaseAnalyzer\Logger($loggingMode);
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
     * Tests Logger->Construct()
     * @test
     */
    public function construct()
    {
        /* @todo complete PHPUnit Test */
        $this->markTestIncomplete("Construct test not implemented");

        $this->Logger->cconstruct(/* parameters */);
    }
}
