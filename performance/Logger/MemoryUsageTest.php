<?php
namespace Performance\PhpDatabaseAnalyzer\Logger;

/**
 * Check test case.
 */
class MemoryUsageTest extends \PHPUnit_Framework_TestCase
{

    /**
     *
     * @var $Logger
     */
    private $Logger;

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
        $this->Logger = null;

        parent::tearDown();
    }

    /**
     * Tests Config()
     * @test
     */
    public function constructorEmptyConfigFileName()
    {
        $numberOfEntries = 10000;
        $entries = array();
        
        for ($i = 0; $i < $numberOfEntries; $i++) {
            $str = md5(time());
            $str = substr($str, 0, rand(1, 20));
            $entries[] = array('type' => 'info', 'text' => $str);
        }
        
        $startMemory = memory_get_usage();
        
        $this->Logger = new \PhpDatabaseAnalyzer\Logger('full');
        
        foreach ($entries as $entry) {
            if ($entry['type'] == 'info') {
                $this->Logger->setInfo($entry['text']);
            }
        }
        
        $log = $this->Logger->getLog();
        
        $endMemory = memory_get_usage();
        
        echo "Memory used: ".round(($endMemory - $startMemory) / 1024 / 1024, 4)." MB\n";
        echo "Peak: ".round((memory_get_peak_usage() - $startMemory) / 1024 / 1024, 4)." MB\n";
    }
}
