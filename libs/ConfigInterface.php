<?php
/**
 * Config interface
 *
 * @category  Interface
 * @package   PhpDatabaseAnalyzer
 * @author    Frederik Glücks <frederik@gluecks-online.de>
 * @copyright Copyright (c) 2015
 * @license   http://opensource.org/licenses/gpl-3.0.html GNU Public License
 * @link      https://github.com/ironchrissi/PhpDatabaseAnalyzer
 * @version   0.1
 **/
namespace PhpDatabaseAnalyzer;

interface ConfigInterface
{

    public function __construct($configFileName);

    public function getOutputType();

    public function getDatabaseTestSuiteAsList();

    public function getConnectionParametersOfDatabaseTestSuite($positionInList);
}
