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
namespace PhpDatabaseAnalyzer\Databases\Mysql\Tests\Table;

class Collation implements \PhpDatabaseAnalyzer\DatabaseTestInterface
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
        $this->Logger->setInfo("Start " . __CLASS__);
        
        $this->getData();
        
        $this->checkData();
        
        $this->Logger->setInfo("End " . __CLASS__);
        
        return true;
    }
    
    private function getData()
    {
        $this->data['tables'] = $this->getAllTables();
        
        $this->data['databaseCollation'] = $this->getSchemaDefaultCollation();
        
    }
    
    private function checkData()
    {
        foreach ($this->data['tables'] as $tableName) {
            $tableCollation = $this->getTableCollation($tableName);
            
            // check difference
            if ($tableCollation !== $this->data['databaseCollation']) {
                $this->Logger->setIssue("warning", "Table " . $tableName . " has not the default schema collation (".$this->data['databaseCollation'].")", 5);
            }
        }
    }
    
    private function getSchemaDefaultCollation()
    {
        $query = ("SELECT default_character_set_name 
                   FROM information_schema.SCHEMATA
                   WHERE schema_name = '".$this->Database->getDatabase()."';");
        
        $result = $this->Database->getRow($query);
        
        if (isset($result, $result[0]) === true) {
            return $result[0];
        }
        
        return false;
        
    }
    
    private function getTableCollation($tableName)
    {
        
        $query = ("SELECT 
                       CCSA.character_set_name 
                   FROM 
                       information_schema.`TABLES` T,
                       information_schema.`COLLATION_CHARACTER_SET_APPLICABILITY` CCSA
                   WHERE 
                        CCSA.collation_name = T.table_collation and
                        T.table_schema = '".$this->Database->getDatabase()."' and
                        T.table_name = '".$tableName."';");
        
        $result = $this->Database->getRow($query);
        
        if (isset($result, $result[0])) {
            return $result[0];
        }
        
        return false;
    }
    
    private function getAllTables()
    {
        $query = ("Show Tables;");
        
        $result = $this->Database->getArray($query, 'num');
        
        foreach ($result as $numericKey => $arrayValues) {
            if (isset($arrayValues[0])) {
                $result[$numericKey] = (string) $arrayValues[0];
            }
        }
        
        return $result;
    }
}
