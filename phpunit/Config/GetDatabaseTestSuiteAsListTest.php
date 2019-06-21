<?php
namespace PHPUnit\PhpDatabaseAnalyzer\Config;

/**
 * Check test case.
 */
class GetDatabaseTestSuiteAsListTest extends \PHPUnit\Framework\TestCase
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
     * Tests Config->getDatabaseTestSuiteAsList()
     * @test
     */
    public function getDatabaseTestSuiteAsList()
    {
        $this->Config = new \PhpDatabaseAnalyzer\Config(dirname(__FILE__) . "/../dataProvider/Config/config.xml");
        $databaseTestSuiteList = $this->Config->getDatabaseTestSuiteAsList();

        $this->assertTrue(is_array($databaseTestSuiteList));
        $this->assertEquals(1, count($databaseTestSuiteList));

        $this->assertTrue(is_int($databaseTestSuiteList[0]));
        $this->assertEquals(0, $databaseTestSuiteList[0]);
    }

    /**
     * Tests Config->getDatabaseTestSuiteAsList()
     * @test
     */
    public function getDatabaseTestSuiteAsListWithTwoDatabaseTestSuites()
    {
        $this->Config = new \PhpDatabaseAnalyzer\Config(dirname(__FILE__) . "/../dataProvider/Config/configWithTwoDatabaseTestSuites.xml");
        $databaseTestSuiteList = $this->Config->getDatabaseTestSuiteAsList();

        $this->assertTrue(is_array($databaseTestSuiteList));
        $this->assertEquals(2, count($databaseTestSuiteList));

        $this->assertTrue(is_int($databaseTestSuiteList[0]));
        $this->assertEquals(0, $databaseTestSuiteList[0]);

        $this->assertTrue(is_int($databaseTestSuiteList[1]));
        $this->assertEquals(1, $databaseTestSuiteList[1]);
    }

    /**
     * Tests Config->getDatabaseTestSuiteAsList()
     * @test
     * @expectedException RuntimeException
     * @expectedExceptionMessage databaseTestSuite does not exist in XML config
     */
    public function getDatabaseTestSuiteAsListXmlWithoutDatabaseTestSuite()
    {
        $this->Config = new \PhpDatabaseAnalyzer\Config(dirname(__FILE__) . "/../dataProvider/Config/configWithoutDatabaseTestSuite.xml");
        $this->Config->getDatabaseTestSuiteAsList();
    }
}
