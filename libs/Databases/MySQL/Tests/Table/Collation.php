<?php
/**
 * Mysqli Table Collation Test Class
 * Find diffence between database schema collation and table collation
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

class Collation implements \PhpDatabaseAnalyzer\DatabaseTestInterface
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
        $this->data['tables'] = $this->Structure->getAllTables();

        $this->data['databaseCollation'] = $this->getSchemaDefaultCollation();
    }

    private function checkData()
    {
        foreach ($this->data['tables'] as $tableName) {
            $tableCollation = $this->getTableCollation($tableName);

            // check difference
            if ($tableCollation !== $this->data['databaseCollation']) {
                $this->Logger->setIssue("warning", "Table " . $tableName . " (" . $tableCollation . ") has not the default schema collation (" . $this->data['databaseCollation'] . ")", 5);
            }
        }
    }

    private function getSchemaDefaultCollation()
    {
        $query = ("SELECT
                        default_collation_name
                   FROM
                        information_schema.SCHEMATA
                   WHERE
                        schema_name = '" . $this->Database->getDatabase() . "';");

        $result = $this->Database->getRow($query);

        if (isset($result, $result[0]) === true) {
            return $result[0];
        }

        return false;
    }

    private function getTableCollation($tableName)
    {
        $query = ("SELECT
                       b.collation_name
                   FROM
                       information_schema.`TABLES` as a,
                       information_schema.`COLLATION_CHARACTER_SET_APPLICABILITY` b
                   WHERE
                        b.collation_name = a.table_collation and
                        a.table_schema = '" . $this->Database->getDatabase() . "' and
                        a.table_name = '" . $tableName . "';");

        $result = $this->Database->getRow($query);

        if (isset($result, $result[0])) {
            return $result[0];
        }

        return false;
    }
}
