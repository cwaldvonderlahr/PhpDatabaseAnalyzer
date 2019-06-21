<?php
namespace PHPUnit\PhpDatabaseAnalyzer\Databases\MySQL\Connection;

/**
 * Check test case.
 */
class GetInstanceTest extends \PHPUnit\Framework\TestCase
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
     * Tests Connection->getInstance()
     * @test
     */
    public function getInstance()
    {
        \PhpDatabaseAnalyzer\Databases\MySQL\Connection::destroyInstance();
        $this->Connection= \PhpDatabaseAnalyzer\Databases\MySQL\Connection::getInstance();

        $this->assertTrue(is_object($this->Connection));
        $this->assertEquals("PhpDatabaseAnalyzer\Databases\MySQL\Connection", get_class($this->Connection));
    }

}
