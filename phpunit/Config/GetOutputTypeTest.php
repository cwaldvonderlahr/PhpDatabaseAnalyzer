<?php
namespace PHPUnit\PhpDatabaseAnalyzer\Config;

/**
 * Check test case.
 */
class GetOutputTypeTest extends \PHPUnit\Framework\TestCase
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
     */
    public function getOutputType()
    {
        $this->Config = new \PhpDatabaseAnalyzer\Config(dirname(__FILE__) . "/../dataProvider/Config/config.xml");
        $outputType = $this->Config->getOutputType();
        $this->assertTrue(is_string($outputType));
        $this->assertEquals("XML", $outputType);
    }

    /**
     * Tests Config->getOutputType()
     * @test
     * @expectedException RuntimeException
     * @expectedExceptionMessage outputType does not exist in XML config
     */
    public function getOutputTypeXmlWithoutOutputType()
    {
        $this->Config = new \PhpDatabaseAnalyzer\Config(dirname(__FILE__) . "/../dataProvider/Config/configWithoutOutputType.xml");
        $this->Config->getOutputType();
    }
}
