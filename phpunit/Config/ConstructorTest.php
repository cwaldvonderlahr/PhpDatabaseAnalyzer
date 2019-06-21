<?php
namespace PHPUnit\PhpDatabaseAnalyzer\Config;

/**
 * Check test case.
 */
class ConstructorTest extends \PHPUnit\Framework\TestCase
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
     * Tests Config->getOutputType()
     * @test
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage Config file does not exists
     */
    public function constructorEmptyConfigFileName()
    {
        $this->Config = new \PhpDatabaseAnalyzer\Config("");
    }

    /**
     * Tests Config->getOutputType()
     * @test
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage Config file does not exists
     */
    public function constructorNotExistingConfigFileName()
    {
        $this->Config = new \PhpDatabaseAnalyzer\Config("/test.xml");
    }

    /**
     * Tests Config->getOutputType()
     * @test
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage Invalid config file
     */
    public function constructorInvalidConfigFileName()
    {
        $this->Config = new \PhpDatabaseAnalyzer\Config(dirname(__FILE__) . "/../dataProvider/Config/invalidConfig.xml");
    }

    /**
     * Tests Config->getOutputType()
     * @test
     */
    public function constructorValidConfigFileName()
    {
        $this->Config = new \PhpDatabaseAnalyzer\Config(dirname(__FILE__) . "/../dataProvider/Config/config.xml");

        $this->assertTrue(is_object($this->Config));
    }
}
