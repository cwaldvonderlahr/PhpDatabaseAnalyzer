<?php
/**
 * Mysqli Table Charset Test Class
 *
 * @category  Database
 * @package   PhpDatabaseAnalyzer
 * @author    Christian Wald-von der Lahr <dev@wald-vonderlahr.de>
 * @copyright Copyright (c) 2015
 * @license   http://opensource.org/licenses/gpl-3.0.html GNU Public License
 * @link      https://github.com/ironchrissi/PhpDatabaseAnalyzer
 * @version   0.1
 **/
namespace PhpDatabaseAnalyzer\Databases\Mysql\Tests\Table;

class Charset implements \PhpDatabaseAnalyzer\DatabaseTestInterface
{

    protected $Database;

    protected $Logger;

    private $data;

    public function __construct(\PhpDatabaseAnalyzer\Databases\Mysql\Connection $Database, \PhpDatabaseAnalyzer\Logger $Logger)
    {
        $this->Database = $Database;
        $this->Logger = $Logger;
    }

    public function runTest()
    {
        // $this->Logger->setInfo("Start " . __CLASS__);

        $this->Logger->setInfo("Test not implemented " . __CLASS__);

        // $this->Logger->setInfo("End " . __CLASS__);

        return true;
    }
}
