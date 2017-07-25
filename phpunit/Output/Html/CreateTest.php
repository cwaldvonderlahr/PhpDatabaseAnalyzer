<?php
namespace PHPUnit\PhpDatabaseAnalyzer\Output\Html;

/**
 * Check test case.
 */
class CreateTest extends \PHPUnit_Framework_TestCase
{

    /**
     *
     * @var Html
     */
    private $Html;

    /**
     * Prepares the environment before running a test.
     */
    protected function setUp()
    {
        $this->Html = new \PhpDatabaseAnalyzer\Output\Html();
        parent::setUp();
    }

    /**
     * Cleans up the environment after running a test.
     */
    protected function tearDown()
    {
        $this->Html = null;

        parent::tearDown();
    }

    /**
     * Tests Html->create()
     * @test
     */
    public function createWithEmptyLogger()
    {
        $Logger = new \PhpDatabaseAnalyzer\Logger('full');

        $output = $this->Html->create($Logger);

        $doc = new \DOMDocument(5);
        $this->assertTrue($doc->loadHTML($output));

        $xpath = new \DOMXPath($doc);

        $this->assertEquals("PhpDatabaseAnalyzer test result", $xpath->query("/html/head/title")[0]->nodeValue);

        $this->assertEquals(2, $xpath->query("/html/body//table")->length);

        $this->assertEquals("0", $xpath->query("((/html/body//table)[1]/tbody/tr)[1]/td")[1]->nodeValue);
        $this->assertEquals("0", $xpath->query("((/html/body//table)[1]/tbody/tr)[2]/td")[1]->nodeValue);
        $this->assertEquals("0", $xpath->query("((/html/body//table)[1]/tbody/tr)[3]/td")[1]->nodeValue);
        $this->assertEquals("0", $xpath->query("((/html/body//table)[1]/tbody/tr)[4]/td")[1]->nodeValue);
        $this->assertEquals("0", $xpath->query("((/html/body//table)[1]/tbody/tr)[5]/td")[1]->nodeValue);

        $this->assertEquals(0, $xpath->query("(/html/body//table)[2]/tbody/tr")->length);
    }

    /**
     * Tests Html->create()
     * @test
     */
    public function createNotEmptyLogger()
    {
        $Logger = new \PhpDatabaseAnalyzer\Logger('full');
        $Logger->setInfo("Start Test");

        $Logger->setIssue("warning", "not", 11);
        $Logger->setIssue("notice", "tmp", 1);
        $Logger->setIssue("critical", "danger", 40);

        $output = $this->Html->create($Logger);

        $doc = new \DOMDocument(5);
        $this->assertTrue($doc->loadHTML($output));

        $xpath = new \DOMXPath($doc);

        $this->assertEquals("PhpDatabaseAnalyzer test result", $xpath->query("/html/head/title")[0]->nodeValue);

        $this->assertEquals(2, $xpath->query("/html/body//table")->length);

        $this->assertEquals("1", $xpath->query("((/html/body//table)[1]/tbody/tr)[1]/td")[1]->nodeValue);
        $this->assertEquals("1", $xpath->query("((/html/body//table)[1]/tbody/tr)[2]/td")[1]->nodeValue);
        $this->assertEquals("1", $xpath->query("((/html/body//table)[1]/tbody/tr)[3]/td")[1]->nodeValue);
        $this->assertEquals("1", $xpath->query("((/html/body//table)[1]/tbody/tr)[4]/td")[1]->nodeValue);
        $this->assertEquals("52", $xpath->query("((/html/body//table)[1]/tbody/tr)[5]/td")[1]->nodeValue);

        $this->assertEquals(4, $xpath->query("(/html/body//table/tbody)[2]/tr")->length);

        $this->assertEquals("info", $xpath->query("((/html/body//table)[2]/tbody/tr)[1]/td")[1]->nodeValue);
        $this->assertEquals("Start Test", $xpath->query("((/html/body//table)[2]/tbody/tr)[1]/td")[2]->nodeValue);
        $this->assertEquals("", $xpath->query("((/html/body//table)[2]/tbody/tr)[1]/td")[3]->nodeValue);

        $this->assertEquals("issue - warning", $xpath->query("((/html/body//table)[2]/tbody/tr)[2]/td")[1]->nodeValue);
        $this->assertEquals("not", $xpath->query("((/html/body//table)[2]/tbody/tr)[2]/td")[2]->nodeValue);
        $this->assertEquals("11", $xpath->query("((/html/body//table)[2]/tbody/tr)[2]/td")[3]->nodeValue);

        $this->assertEquals("issue - notice", $xpath->query("((/html/body//table)[2]/tbody/tr)[3]/td")[1]->nodeValue);
        $this->assertEquals("tmp", $xpath->query("((/html/body//table)[2]/tbody/tr)[3]/td")[2]->nodeValue);
        $this->assertEquals("1", $xpath->query("((/html/body//table)[2]/tbody/tr)[3]/td")[3]->nodeValue);

        $this->assertEquals("issue - critical", $xpath->query("((/html/body//table)[2]/tbody/tr)[4]/td")[1]->nodeValue);
        $this->assertEquals("danger", $xpath->query("((/html/body//table)[2]/tbody/tr)[4]/td")[2]->nodeValue);
        $this->assertEquals("40", $xpath->query("((/html/body//table)[2]/tbody/tr)[4]/td")[3]->nodeValue);
    }
}
