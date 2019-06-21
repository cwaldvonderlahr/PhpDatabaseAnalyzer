<?php
/**
 * Mysqli Column Collation Test Class
 * Find diffence between table collation and column collation
 *
 * @category  Database
 * @package   PhpDatabaseAnalyzer
 * @author    Christian Wald-von der Lahr <dev@wald-vonderlahr.de>
 * @copyright Copyright (c) 2015
 * @license   http://opensource.org/licenses/gpl-3.0.html GNU Public License
 * @link      https://github.com/cwaldvonderlahr/PhpDatabaseAnalyzer
 * @version   0.1
 **/
namespace PhpDatabaseAnalyzer\Databases\MySQL\Tests\Column;

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
    }

    private function checkData()
    {
        foreach ($this->data['tables'] as $tableName) {
            $tableCollation = $this->getTableCollation($tableName);
            $columns = $this->getColumns($tableName);

            foreach ($columns as $columnName) {
                // check difference
                $columnsCollation = $this->getColumnsCollation($tableName, $columnName);

                if ($columnsCollation !== false && $tableCollation !== $columnsCollation) {
                    $this->Logger->setIssue("warning", "Table " . $tableName . " - Column " . $columnName . " (" . $columnsCollation . ") has not the same Collation as the table " . $tableName . " (" . $tableCollation . ")", 5);
                }
            }
        }
    }

    private function getTableCollation($tableName)
    {
        $query = ("SELECT
                       CCSA.collation_name
                   FROM
                       information_schema.`TABLES` T,
                       information_schema.`COLLATION_CHARACTER_SET_APPLICABILITY` CCSA
                   WHERE
                        CCSA.collation_name = T.table_collation and
                        T.table_schema = '" . $this->Database->getDatabase() . "' and
                        T.table_name = '" . $tableName . "';");

        $result = $this->Database->getRow($query);

        if (isset($result, $result[0])) {
            return $result[0];
        }

        return false;
    }

    private function getColumnsCollation($tableName, $columnName)
    {
        $query = ("SELECT
                      collation_name
                  FROM
                      information_schema.`COLUMNS`
                  WHERE
                      table_schema = '" . $this->Database->getDatabase() . "' and
                      table_name = '" . $tableName . "' and
                      column_name = '" . $columnName . "';");

        $result = $this->Database->getRow($query);

        if (isset($result, $result[0]) === true) {
            return $result[0];
        }

        return false;
    }

    private function getColumns($tableName)
    {
        $query = (" SELECT
                        COLUMN_NAME
                    FROM
                        INFORMATION_SCHEMA.COLUMNS
                    WHERE
                        TABLE_SCHEMA = '" . $this->Database->getDatabase() . "' AND
                        TABLE_NAME = '" . $tableName . "';");

        $result = $this->Database->getArray($query, 'num');

        foreach ($result as $numericKey => $arrayValues) {
            if (isset($arrayValues[0])) {
                $result[$numericKey] = (string) $arrayValues[0];
            }
        }

        return $result;
    }
}
