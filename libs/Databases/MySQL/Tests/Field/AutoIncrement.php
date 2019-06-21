<?php
/**
 * Mysqli Autoincrement Test Class
 * Find AutoIncrement Values that are near the maximum value of the datatype
 *
 * @category  Database
 * @package   PhpDatabaseAnalyzer
 * @author    Christian Wald-von der Lahr <dev@wald-vonderlahr.de>
 * @copyright Copyright (c) 2015
 * @license   http://opensource.org/licenses/gpl-3.0.html GNU Public License
 * @link      https://github.com/cwaldvonderlahr/PhpDatabaseAnalyzer
 * @version   0.1
 **/
namespace PhpDatabaseAnalyzer\Databases\MySQL\Tests\Field;

class AutoIncrement implements \PhpDatabaseAnalyzer\DatabaseTestInterface
{

    protected $Database;

    protected $Structure;

    protected $Logger;

    private $data;

    private $datatypeMaxValues = array(
        'tinyint' => array(
            'signed' => 127,
            'unsigned' => 255
        ),
        'smallint' => array(
            'signed' => 32767,
            'unsigned' => 65535
        ),
        'mediumint' => array(
            'signed' => 8388607,
            'unsigned' => 16777215
        ),
        'int' => array(
            'signed' => 2147483647,
            'unsigned' => 4294967295
        ),
        'bigint' => array(
            'signed' => 9223372036854775807,
            'unsigned' => 18446744073709551615
        )
    );

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

        $this->data = $this->getColumsWithAutoIncrement($allTables);
        if ($this->data === false) {
            return false;
        }

        unset($allTables);

        $this->getAutoIncrementValues($this->data);
    }

    private function checkData()
    {
        foreach ($this->data as $tableName => $tableValues) {
            $dataType = $this->splitColumnDataType($tableValues['Type']);

            unset($this->data[$tableName]['Type'], $this->data[$tableName]['Extra']);

            $this->data[$tableName]['type'] = $dataType['type'];
            $this->data[$tableName]['typeLength'] = $dataType['typeLength'];

            if (isset($dataType['unsigned'])) {
                $this->data[$tableName]['unsigned'] = (bool) true;
            }

            unset($dataType);

            if (isset($this->datatypeMaxValues[$this->data[$tableName]['type']])) {
                $maxValue = $this->datatypeMaxValues[$this->data[$tableName]['type']]['signed'];

                if (isset($this->data[$tableName]['unsigned']) && $this->data[$tableName]['unsigned'] == true) {
                    $maxValue = $this->datatypeMaxValues[$this->data[$tableName]['type']]['unsigned'];
                }

                $currentValue = $this->data[$tableName]['autoIncrementValue'];

                // Difference
                $differenceToMaxValue = $maxValue - $currentValue;
                $percentOfAutoIncrementStatus = (int) round(($currentValue / $maxValue) * 100, 0);

                if ($percentOfAutoIncrementStatus > 90) {
                    $this->Logger->setIssue("error", "Table " . $tableName . " - " . $percentOfAutoIncrementStatus . "% of AutoIncrement reached - ".$differenceToMaxValue." to max value", 10);
                } elseif ($percentOfAutoIncrementStatus > 70) {
                    $this->Logger->setIssue("warning", "Table " . $tableName . " - " . $percentOfAutoIncrementStatus . "% of AutoIncrement reached - ".$differenceToMaxValue." to max value", 5);
                } elseif ($percentOfAutoIncrementStatus > 50) {
                    $this->Logger->setIssue("notice", "Table " . $tableName . " - " . $percentOfAutoIncrementStatus . "% of AutoIncrement reached - ".$differenceToMaxValue." to max value", 1);
                }

                unset($currentValue, $maxValue, $differenceToMaxValue, $percentOfAutoIncrementStatus);
            }
        }
    }

    private function splitColumnDataType($dataTypeString)
    {
        $datatype = array();
        $matchTypeLength = preg_match('/\(.*?\)/', $dataTypeString, $TypeLengthMatches);

        if ($matchTypeLength !== false) {
            $TypeLengthMatches = preg_replace('@\(?\)?@', '', $TypeLengthMatches);
            $datatype['typeLength'] = (int) $TypeLengthMatches[0];
        }

        $dataTypeString = preg_replace('@\(.*?\)@', '', $dataTypeString);

        $datatypeStringParts = explode(" ", $dataTypeString);

        $datatype['type'] = $datatypeStringParts[0];

        if (isset($datatypeStringParts[1])) {
            $datatype['unsigned'] = $datatypeStringParts[1];
        }

        return $datatype;
    }

    private function getColumsWithAutoIncrement($tables)
    {
        $columns = array();
        $return = array();

        foreach ($tables as $table) {
            $query = ("SHOW COLUMNS FROM " . $table . "");

            $columns = $this->Database->getArray($query, 'assoc');

            foreach ($columns as $columnAttributes) {
                if ($columnAttributes['Extra'] == (string) 'auto_increment') {
                    $return[$table]['Field'] = $columnAttributes['Field'];
                    $return[$table]['Type'] = $columnAttributes['Type'];
                    $return[$table]['Extra'] = $columnAttributes['Extra'];
                }
            }
        }

        unset($columns, $columnAttributes);

        return $return;
    }

    private function getAutoIncrementValues(&$columns)
    {
        foreach ($columns as $tableName => $values) {
            $query = ("
                        SELECT
                            AUTO_INCREMENT
                        FROM
                            INFORMATION_SCHEMA.TABLES
                        WHERE
                            TABLE_SCHEMA = '" . $this->Database->getDatabase() . "' AND
                            TABLE_NAME   = '" . $tableName . "';
                            ");

            $autoIncrementValue = (int) $this->Database->getRow($query)[0];

            if (isset($autoIncrementValue) && ! empty($autoIncrementValue)) {
                $columns[$tableName]['autoIncrementValue'] = $autoIncrementValue;
            }
        }

        return true;
    }
}
