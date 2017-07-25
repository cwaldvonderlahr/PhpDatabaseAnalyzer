<?php
namespace PHPUnit\PhpDatabaseAnalyzer\Databases\MySQL\Structure;

/**
 * Check test case.
 */
class GetAllTablesTest extends \PHPUnit_Framework_TestCase
{

    /**
     *
     * @var Structure
     */
    private $Structure;

    /**
     * Prepares the environment before running a test.
     */
    protected function setUp()
    {
        parent::setUp();
    }

    protected function setConnection()
    {
        $Connection = new \PhpDatabaseAnalyzer\Databases\MySQL\Connection();
        $Connection->set("localhost", "root", "", "mysql", 3306, "/usr/local/zend/mysql/tmp/mysql.sock");

        return $Connection;
    }

    /**
     * Cleans up the environment after running a test.
     */
    protected function tearDown()
    {
        $this->Structure = null;

        parent::tearDown();
    }

    /**
     * Tests Structure->start()
     * @test
     */
    public function getTables()
    {
        $this->Structure = new \PhpDatabaseAnalyzer\Databases\MySQL\Structure($this->setConnection());

        $tables = $this->Structure->getAllTables();

        $this->assertTrue(is_array($tables));

        $this->assertEquals(24, count($tables));

        $this->assertTrue(in_array("slow_log", $tables));
    }
}
