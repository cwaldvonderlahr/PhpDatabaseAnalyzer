<?php
namespace PHPUnit\PhpDatabaseAnalyzer\PhpDatabaseAnalyzer;

/**
 * Check test case.
 */
class StartTest extends \PHPUnit_Framework_TestCase
{

    /**
     *
     * @var Html
     */
    private $PhpDatabaseAnalyzer;

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
        $this->PhpDatabaseAnalyzer = null;

        parent::tearDown();
    }

    /**
     * Tests PhpDatabaseAnalyzer->start()
     * @test
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage Config file does not exists
     */
    public function configFileDoesNotExist()
    {
        $this->PhpDatabaseAnalyzer = new \PhpDatabaseAnalyzer\PhpDatabaseAnalyzer(null);
    }

    /**
     * Tests PhpDatabaseAnalyzer->start()
     * @test
     * @expectedException RuntimeException
     * @expectedExceptionMessage Database connection class does not exists: \PhpDatabaseAnalyzer\Databases\TestEngine\Connection
     */
    public function unkownDatabaseEngine()
    {
        $configFile = dirname(__FILE__) . "/../phpunit_invalid_engine.xml";
        $this->PhpDatabaseAnalyzer = new \PhpDatabaseAnalyzer\PhpDatabaseAnalyzer($configFile);

        $output = $this->PhpDatabaseAnalyzer->start();

        $this->assertNotFalse($output);
    }

    /**
     * Tests PhpDatabaseAnalyzer->start()
     * @test
     * @expectedException RuntimeException
     * @expectedExceptionMessage Output class does not exists
     */
    public function unknownOutputType()
    {
        $configFile = dirname(__FILE__) . "/../phpunit_invalid_output.xml";
        $this->PhpDatabaseAnalyzer = new \PhpDatabaseAnalyzer\PhpDatabaseAnalyzer($configFile);

        $output = $this->PhpDatabaseAnalyzer->start();

        $this->assertNotFalse($output);
    }

    /**
     * Tests PhpDatabaseAnalyzer->start()
     * @test
     */
    public function defaultRun()
    {
        $configFile = dirname(__FILE__) . "/../phpunit_valid.xml";
        $this->PhpDatabaseAnalyzer = new \PhpDatabaseAnalyzer\PhpDatabaseAnalyzer($configFile);

        $output = $this->PhpDatabaseAnalyzer->start();

        $this->assertNotEmpty($output);
    }

}
