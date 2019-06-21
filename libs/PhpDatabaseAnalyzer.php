<?php
/**
 * PhpDatabaseAnalyzer Class
 *
 * @category  Main
 * @package   PhpDatabaseAnalyzer
 * @author    Frederik Glücks <frederik@gluecks-online.de>
 * @copyright Copyright (c) 2015
 * @license   http://opensource.org/licenses/gpl-3.0.html GNU Public License
 * @link      https://github.com/cwaldvonderlahr/PhpDatabaseAnalyzer
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
        return $this->runDatabaseTestSuites();
    }

    private function runDatabaseTestSuites()
    {
        $databaseTestSuiteLists = $this->Config->getDatabaseTestSuiteAsList();

        $Logger = new Logger($this->Config->getLoggingMode());

        foreach ($databaseTestSuiteLists as $databaseTestSuiteId) {
            $connectionData = $this->Config->getConnectionParametersOfDatabaseTestSuite($databaseTestSuiteId);

            $connectionClass = '\PhpDatabaseAnalyzer\Databases\\' . $connectionData['engine'] . '\Connection';
            $structureClass =  '\PhpDatabaseAnalyzer\Databases\\' . $connectionData['engine'] . '\Structure';

            $Logger->setInfo("Database: " . $connectionData['database']);

            if (! class_exists($connectionClass)) {
                throw new \RuntimeException("Database connection class does not exists: " . $connectionClass, E_ERROR);
            } else {
                $ConnectionObject = new $connectionClass();
                $ConnectionObject->set($connectionData['host'], $connectionData['username'], $connectionData['password'], $connectionData['database'], $connectionData['port'], $connectionData['socket']);

                $Structure = new $structureClass($ConnectionObject);

                $testList = $this->getAllTestsOfDatabaseEngine($connectionData['engine']);

                foreach ($testList as $testCLass) {
                    if (class_exists($testCLass)) {
                        $testClass = new $testCLass($ConnectionObject, $Structure, $Logger);
                        $testClass->runTest();
                        unset($testCLass);
                    }
                }
            }
        }

        return $this->createOutput($Logger);
    }

    private function getAllTestsOfDatabaseEngine($databaseEngine)
    {
        $tests = array();

        $testsCases = array(
            'Column',
            'Field',
            'Table'
        );

        $classPrefix = '\PhpDatabaseAnalyzer\Databases\\' . $databaseEngine . '\Tests\\';

        foreach ($testsCases as $testCases) {
            $dir = dirname(__FILE__) . "/Databases/" . $databaseEngine . "/Tests/" . $testCases . "/";

            $handle = opendir($dir);
            if ($handle) {
                while (false !== ($entry = readdir($handle))) {
                    if ($entry != "." && $entry != "..") {
                        if (substr($entry, - 4) == '.php') {
                            $tests[] = $classPrefix . $testCases . '\\' . substr($entry, 0, - 4);
                        }
                    }
                }
                closedir($handle);
            }
        }

        return $tests;
    }

    private function createOutput($Logger)
    {
        $outputClass = '\PhpDatabaseAnalyzer\Output\\' . $this->Config->getOutputType();

        if (! class_exists($outputClass)) {
            throw new \RuntimeException("Output class does not exists", E_ERROR);
        } else {
            $Output = new $outputClass();
            return $Output->create($Logger);
        }
    }
}
