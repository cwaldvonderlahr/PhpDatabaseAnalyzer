<?php
namespace PHPUnit\PhpDatabaseAnalyzer\Databases\MySQL\Connection;

/**
 * Check test case.
 */
class SetTest extends \PHPUnit_Framework_TestCase
{

    /**
     *
     * @var Connection
     */
    private $Connection;

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
        $this->Structure = null;

        parent::tearDown();
    }

    /**
     * Tests Connection->set()
     * @test
     */
    public function validConnection()
    {
        $Connection = new \PhpDatabaseAnalyzer\Databases\MySQL\Connection();
        $Connection->set("localhost", "root", "", "mysql", 3306, "/usr/local/zend/mysql/tmp/mysql.sock");

        $this->assertTrue(is_object($Connection));
    }

    /**
     * Tests Connection->set()
     * @test
     */
    public function validConnectionWithoutPort()
    {
        $Connection = new \PhpDatabaseAnalyzer\Databases\MySQL\Connection();
        $Connection->set("localhost", "root", "", "mysql", null, "/usr/local/zend/mysql/tmp/mysql.sock");

        $this->assertTrue(is_object($Connection));
    }

    /**
     * Tests Connection->set()
     * @test
     */
    public function validConnectionWithoutSocket()
    {
        $Connection = new \PhpDatabaseAnalyzer\Databases\MySQL\Connection();
        $Connection->set("localhost", "root", "", "mysql");

        $this->assertTrue(is_object($Connection));
    }

    /**
     * Tests Connection->set()
     * @test
     * @expectedException Exception
     * @expectedExceptionMessage Empty Username
     */
    public function emptyUser()
    {
        $Connection = new \PhpDatabaseAnalyzer\Databases\MySQL\Connection();
        $Connection->set("localhost", "", "", "mysql");
    }

    /**
     * Tests Connection->set()
     * @test
     * @expectedException Exception
     * @expectedExceptionMessage Empty Database
     */
    public function emptyDatabase()
    {
        $Connection = new \PhpDatabaseAnalyzer\Databases\MySQL\Connection();
        $Connection->set("localhost", "root", "", "");
    }

    /**
     * Tests Connection->set()
     * @test
     * @expectedException Exception
     * @expectedExceptionMessage Empty Host
     */
    public function emptyHost()
    {
        $Connection = new \PhpDatabaseAnalyzer\Databases\MySQL\Connection();
        $Connection->set("", "root", "", "mysql");
    }

    /**
     * Tests Connection->set()
     * @test
     * @expectedException PHPUnit_Framework_Error_Warning
     */
    public function invalidUser()
    {
        $Connection = new \PhpDatabaseAnalyzer\Databases\MySQL\Connection();
        $Connection->set("localhost", "ro", "", "mysql", 3306, "/usr/local/zend/mysql/tmp/mysql.sock");

        $this->assertTrue(is_object($Connection));
    }

    /**
     * Tests Connection->set()
     * @test
     */
    public function setCharset()
    {
        $Connection = new \PhpDatabaseAnalyzer\Databases\MySQL\Connection();
        $Connection->set("localhost", "root", "", "mysql", 3306, "/usr/local/zend/mysql/tmp/mysql.sock", "latin1");

        $this->assertTrue(is_object($Connection));
    }
}
