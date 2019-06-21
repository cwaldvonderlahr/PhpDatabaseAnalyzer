<?php
namespace PHPUnit\PhpDatabaseAnalyzer\Config;

/**
 * Check test case.
 */
class GetLoggingModeTest extends \PHPUnit\Framework\TestCase
{

    /**
     *
     * @var Config
     */
    private $Config;

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
        $this->Config = null;

        parent::tearDown();
    }

    /**
     * Tests Config->getLoggingMode()
     * @test
     */
    public function getLoggingMode()
    {
        $this->Config = new \PhpDatabaseAnalyzer\Config(dirname(__FILE__) . "/../dataProvider/Config/config.xml");
        $loggingMode = $this->Config->getLoggingMode();
        $this->assertTrue(is_string($loggingMode));
        $this->assertEquals("full", $loggingMode);
    }

    /**
     * Tests Config->getLoggingMode()
     * @test
     * @expectedException RuntimeException
     * @expectedExceptionMessage loggingMode does not exist in XML config
     */
    public function getLoggingModeXmlWithoutLoggingMode()
    {
        $this->Config = new \PhpDatabaseAnalyzer\Config(dirname(__FILE__) . "/../dataProvider/Config/configWithoutLoggingMode.xml");
        $this->Config->getLoggingMode();
    }
}
