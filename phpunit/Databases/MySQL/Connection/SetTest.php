<?php
namespace PHPUnit\PhpDatabaseAnalyzer\Databases\MySQL\Connection;

/**
 * Check test case.
 */
class SetTest extends \PHPUnit\Framework\TestCase
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
    	$this->Connection= new \PhpDatabaseAnalyzer\Databases\MySQL\Connection();
    	$this->Connection->set("localhost", "root", "", "mysql", 3306, "/usr/local/zend/mysql/tmp/mysql.sock");

    	$this->assertTrue(is_object($this->Connection));
    }

    /**
     * Tests Connection->set()
     * @test
     */
    public function validConnectionWithoutPort()
    {
    	$this->Connection= new \PhpDatabaseAnalyzer\Databases\MySQL\Connection();
    	$this->Connection->set("localhost", "root", "", "mysql", null, "/usr/local/zend/mysql/tmp/mysql.sock");

    	$this->assertTrue(is_object($this->Connection));
    }

    /**
     * Tests Connection->set()
     * @test
     */
    public function validConnectionWithoutSocket()
    {
    	$this->Connection= new \PhpDatabaseAnalyzer\Databases\MySQL\Connection();
    	$this->Connection->set("localhost", "root", "", "mysql");

    	$this->assertTrue(is_object($this->Connection));
    }

    /**
     * Tests Connection->set()
     * @test
     * @expectedException Exception
     * @expectedExceptionMessage Empty Username
     */
    public function emptyUser()
    {
    	$this->Connection= new \PhpDatabaseAnalyzer\Databases\MySQL\Connection();
    	$this->Connection->set("localhost", "", "", "mysql");
    }

    /**
     * Tests Connection->set()
     * @test
     * @expectedException Exception
     * @expectedExceptionMessage Empty Database
     */
    public function emptyDatabase()
    {
    	$this->Connection= new \PhpDatabaseAnalyzer\Databases\MySQL\Connection();
    	$this->Connection->set("localhost", "root", "", "");
    }

    /**
     * Tests Connection->set()
     * @test
     * @expectedException Exception
     * @expectedExceptionMessage Empty Host
     */
    public function emptyHost()
    {
    	$this->Connection = new \PhpDatabaseAnalyzer\Databases\MySQL\Connection();
    	$this->Connection->set("", "root", "", "mysql");
    }

    /**
     * Tests Connection->set()
     * @test
     * @expectedException PHPUnit_Framework_Error_Warning
     */
    public function invalidUser()
    {
    	$this->Connection= new \PhpDatabaseAnalyzer\Databases\MySQL\Connection();
    	$this->Connection->set("localhost", "ro", "", "mysql", 3306, "/usr/local/zend/mysql/tmp/mysql.sock");

    	$this->assertTrue(is_object($this->Connection));
    }

    /**
     * Tests Connection->set()
     * @test
     */
    public function setCharset()
    {
    	$this->Connection= new \PhpDatabaseAnalyzer\Databases\MySQL\Connection();
    	$this->Connection->set("localhost", "root", "", "mysql", 3306, "/usr/local/zend/mysql/tmp/mysql.sock", "latin1");

    	$this->assertTrue(is_object($this->Connection));
    }
}
