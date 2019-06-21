<?php
namespace PHPUnit\PhpDatabaseAnalyzer\Databases\MySQL\Connection;

/**
 * Check test case.
 */
class GetCharsetTest extends \PHPUnit\Framework\TestCase
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
     * Tests Connection->getCharset()
     * @test
     */
    public function setOwnCharset()
    {
        $this->Connection = new \PhpDatabaseAnalyzer\Databases\MySQL\Connection();
        $this->Connection->set("localhost", "root", "", "mysql", 3306, "/usr/local/zend/mysql/tmp/mysql.sock", "latin1");

        $this->assertTrue(is_object($this->Connection));
        $this->assertEquals("latin1", $this->Connection->getCharset());
    }

    /**
     * Tests Connection->getCharset()
     * @test
     */
    public function getDefaultCharset()
    {
    	$this->Connection= new \PhpDatabaseAnalyzer\Databases\MySQL\Connection();
    	$this->Connection->set("localhost", "root", "", "mysql");

    	$this->assertTrue(is_object($this->Connection));
    	$this->assertEquals("", $this->Connection->getCharset());
    }
}
