<?php
namespace PHPUnit\PhpDatabaseAnalyzer\Databases\MySQL\Connection;

/**
 * Check test case.
 */
class GetCharsetTest extends \PHPUnit_Framework_TestCase
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
        $Connection = new \PhpDatabaseAnalyzer\Databases\MySQL\Connection();
        $Connection->set("localhost", "root", "", "mysql", 3306, "/usr/local/zend/mysql/tmp/mysql.sock", "latin1");

        $this->assertTrue(is_object($Connection));
        $this->assertEquals("latin1", $Connection->getCharset());
    }

    /**
     * Tests Connection->getCharset()
     * @test
     */
    public function getDefaultCharset()
    {
        $Connection = new \PhpDatabaseAnalyzer\Databases\MySQL\Connection();
        $Connection->set("localhost", "root", "", "mysql");

        $this->assertTrue(is_object($Connection));
        $this->assertEquals("", $Connection->getCharset());
    }
}
