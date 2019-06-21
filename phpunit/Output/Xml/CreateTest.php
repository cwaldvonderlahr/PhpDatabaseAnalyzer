<?php
namespace PHPUnit\PhpDatabaseAnalyzer\Output\Xml;

/**
 * Check test case.
 */
class CreateTest extends \PHPUnit\Framework\TestCase
{

    /**
     *
     * @var Xml
     */
    private $Xml;

    /**
     * Prepares the environment before running a test.
     */
    protected function setUp()
    {
        $this->Xml = new \PhpDatabaseAnalyzer\Output\Xml();
        parent::setUp();
    }

    /**
     * Cleans up the environment after running a test.
     */
    protected function tearDown()
    {
        $this->Xml = null;

        parent::tearDown();
    }

    /**
     * Tests Xml->create()
     * @test
     */
    public function createWithEmptyLogger()
    {
        $Logger = new \PhpDatabaseAnalyzer\Logger('full');

        $output = $this->Xml->create($Logger);

        $XML = simplexml_load_string($output);

        $this->assertTrue(is_object($XML));

        $this->assertEquals(0, count($XML->line));
    }

    /**
     * Tests Xml->create()
     * @test
     */
    public function createNotEmptyLogger()
    {
        $Logger = new \PhpDatabaseAnalyzer\Logger('full');
        $Logger->setInfo("test");

        $Logger->setIssue("warning", "not", 11);

        $output = $this->Xml->create($Logger);

        $XML = simplexml_load_string($output);

        $this->assertTrue(is_object($XML));

        $this->assertEquals(2, count($XML->line));

        $this->assertEquals("test", $XML->line[0]->text);
        $this->assertEquals("info", $XML->line[0]->logType);

        $this->assertEquals("not", $XML->line[1]->text);
        $this->assertEquals("issue", $XML->line[1]->logType);
        $this->assertEquals("warning", $XML->line[1]->issueType);
        $this->assertEquals("11", $XML->line[1]->scorePoints);
    }
}
