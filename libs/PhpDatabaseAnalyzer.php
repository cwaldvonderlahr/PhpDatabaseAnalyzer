<?php
/**
 * PhpDatabaseAnalyzer Class
 *
 * @category  Main
 * @package   PhpDatabaseAnalyzer
 * @author    Frederik Glücks <frederik@gluecks-online.de>
 * @copyright Copyright (c) 2015
 * @license   http://opensource.org/licenses/gpl-3.0.html GNU Public License
 * @link      https://github.com/ironchrissi/PhpDatabaseAnalyzer
 * @version   0.1
 **/
namespace PhpDatabaseAnalyzer;

class PhpDatabaseAnalyzer implements PhpDatabaseAnalyzerInterface
{

    private $Config;

    public function __construct($configFile)
    {
        if (! file_exists($configFile)) {
            $configFile = dirname(__FILE__) . "/../config/config.xml";
        }
        
        $this->Config = new Config($configFile);
    }

    public function start()
    {
        $this->runDatabaseTestSuites();
    }

    private function runDatabaseTestSuites()
    {
        $databaseTestSuiteLists = $this->Config->getDatabaseTestSuiteAsList();
        
        $Logger = new Logger($this->Config->getLoggingMode());
        
        foreach ($databaseTestSuiteLists as $databaseTestSuiteId) {
            $connectionData = $this->Config->getConnectionParametersOfDatabaseTestSuite($databaseTestSuiteId);
            
            var_dump($connectionData);
        }
        
        $this->createOutput($Logger);
    }

    private function createOutput($Logger)
    {
        /* create output */
    }
}
