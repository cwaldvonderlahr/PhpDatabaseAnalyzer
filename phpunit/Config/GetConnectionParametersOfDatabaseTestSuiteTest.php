<?php
namespace PHPUnit\PhpDatabaseAnalyzer\Config;

/**
 * Check test case.
 */
class GetConnectionParametersOfDatabaseTestSuiteTest extends \PHPUnit_Framework_TestCase
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
     * Tests Config->getConnectionParametersOfDatabaseTestSuite()
     * @test
     */
    public function getConnectionParametersOfDatabaseTestSuite()
    {
        $this->Config = new \PhpDatabaseAnalyzer\Config(dirname(__FILE__)."/../dataProvider/Config/config.xml");
        $databaseTestSuite = $this->Config->getConnectionParametersOfDatabaseTestSuite(0);

        $this->assertTrue(is_array($databaseTestSuite));
        $this->assertEquals(5, count($databaseTestSuite));

        $this->assertArrayHasKey("engine", $databaseTestSuite);
        $this->assertEquals("MySQL", $databaseTestSuite['engine']);

        $this->assertArrayHasKey("host", $databaseTestSuite);
        $this->assertEquals("localhost", $databaseTestSuite['host']);

        $this->assertArrayHasKey("port", $databaseTestSuite);
        $this->assertEquals("3306", $databaseTestSuite['port']);

        $this->assertArrayHasKey("username", $databaseTestSuite);
        $this->assertEquals("root", $databaseTestSuite['username']);

        $this->assertArrayHasKey("password", $databaseTestSuite);
        $this->assertEquals("asdaddfaf", $databaseTestSuite['password']);
    }

    /**
     * Tests Config->getConnectionParametersOfDatabaseTestSuite()
     * @test
     */
    public function getConnectionParametersOfDatabaseTestSuiteWithTwoDatabaseTestSuites()
    {
        $this->Config = new \PhpDatabaseAnalyzer\Config(dirname(__FILE__)."/../dataProvider/Config/configWithTwoDatabaseTestSuites.xml");
        $databaseTestSuite = $this->Config->getConnectionParametersOfDatabaseTestSuite(1);

        $this->assertTrue(is_array($databaseTestSuite));
        $this->assertEquals(5, count($databaseTestSuite));

        $this->assertArrayHasKey("engine", $databaseTestSuite);
        $this->assertEquals("MySQL", $databaseTestSuite['engine']);

        $this->assertArrayHasKey("host", $databaseTestSuite);
        $this->assertEquals("conftec-testdb01", $databaseTestSuite['host']);

        $this->assertArrayHasKey("port", $databaseTestSuite);
        $this->assertEquals("3306", $databaseTestSuite['port']);

        $this->assertArrayHasKey("username", $databaseTestSuite);
        $this->assertEquals("admin", $databaseTestSuite['username']);

        $this->assertArrayHasKey("password", $databaseTestSuite);
        $this->assertEquals("2kkwsk27", $databaseTestSuite['password']);
    }

    /**
     * Tests Config->getConnectionParametersOfDatabaseTestSuite()
     * @test
     * @expectedException RuntimeException
     * @expectedExceptionMessage databaseTestSuite does not exist in XML config
     */
    public function getConnectionParametersOfDatabaseTestSuiteXmlWithoutDatabaseTestSuite()
    {
        $this->Config = new \PhpDatabaseAnalyzer\Config(dirname(__FILE__)."/../dataProvider/Config/configWithTwoDatabaseTestSuites.xml");
        $this->Config->getConnectionParametersOfDatabaseTestSuite(2);
    }
}
