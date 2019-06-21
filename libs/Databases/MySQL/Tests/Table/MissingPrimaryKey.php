<?php
/**
 * Mysqli Table Missing Primary Key Test Class
 *
 * @category  Database
 * @package   PhpDatabaseAnalyzer
 * @author    Christian Wald-von der Lahr <dev@wald-vonderlahr.de>
 * @copyright Copyright (c) 2015
 * @license   http://opensource.org/licenses/gpl-3.0.html GNU Public License
 * @link      https://github.com/cwaldvonderlahr/PhpDatabaseAnalyzer
 * @version   0.1
 **/
namespace PhpDatabaseAnalyzer\Databases\MySQL\Tests\Table;

class MissingPrimaryKey implements \PhpDatabaseAnalyzer\DatabaseTestInterface
{

    protected $Database;

    protected $Structure;

    protected $Logger;

    private $data;

    public function __construct(\PhpDatabaseAnalyzer\Databases\MySQL\Connection $Database, \PhpDatabaseAnalyzer\Databases\MySQL\Structure $Structure, \PhpDatabaseAnalyzer\Logger $Logger)
    {
        $this->Database = $Database;
        $this->Structure = $Structure;
        $this->Logger = $Logger;
    }

    public function runTest()
    {
        $this->Logger->setInfo("Start " . __CLASS__);

        $this->getData();

        $this->checkData();

        $this->Logger->setInfo("End " . __CLASS__);

        return true;
    }

    private function getData()
    {
        $allTables = $this->Structure->getAllTables();
        if ($allTables === false) {
            return false;
        }

        $this->data = $allTables;
    }

    private function checkData()
    {
        foreach ($this->data as $tablename) {
            if ($this->hasPrimaryKey($tablename) !== true) {
                $this->Logger->setIssue("warning", "Table " . $tablename . " has no Primary Key", 5);
            }
        }
    }

    private function hasPrimaryKey($tablename)
    {
        $query = ("SHOW KEYS FROM " . $tablename . " WHERE Key_name = 'PRIMARY'");

        $result = $this->Database->getArray($query, 'assoc');

        if (isset($result, $result[0], $result[0]['Table']) === true && $result[0]['Table'] == $tablename) {
            unset($result);
            return true;
        }

        unset($result);
        return false;
    }
}
