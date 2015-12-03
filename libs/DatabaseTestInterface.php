<?php
/**
* Database Test Interface
*
* @category  Interface
* @package   PhpDatabaseAnalyzer
* @author    Christian Wald-von der Lahr <dev@wald-vonderlahr.de>
* @copyright Copyright (c) 2015
* @license   http://opensource.org/licenses/gpl-3.0.html GNU Public License
* @link      https://github.com/ironchrissi/PhpDatabaseAnalyzer
* @version   0.1
**/
namespace PhpDatabaseAnalyzer;

interface DatabaseTestInterface
{
    public function __construct(\PhpDatabaseAnalyzer\Databases\Mysql\Connection $Database, \PhpDatabaseAnalyzer\Logger $Logger);

    public function runTest();
}
