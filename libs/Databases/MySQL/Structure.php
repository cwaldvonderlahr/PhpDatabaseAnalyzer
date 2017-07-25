<?php
/**
 * Mysqli Connection Class
 *
 * @category  Database
 * @package   PhpDatabaseAnalyzer
 * @author    Frederik Glücks <frederik.gluecks@conftec.de>
 * @copyright Copyright (c) 2017
 * @license   http://opensource.org/licenses/gpl-3.0.html GNU Public License
 * @link      https://github.com/conftec/PhpDatabaseAnalyzer
 * @version   0.1
 **/
namespace PhpDatabaseAnalyzer\Databases\MySQL;

class Structure implements \PhpDatabaseAnalyzer\DatabaseStructureInterface
{

    private $tables = [];

    private $Database = null;

    public function __construct(\PhpDatabaseAnalyzer\Databases\MySQL\Connection $Connection)
    {
        $this->Database = $Connection;
        $this->readAllTables();
    }

    private function readAllTables()
    {
        $query = ("Show Tables;");

        $this->tables = $this->Database->getArray($query, 'num');

        foreach ($this->tables as $numericKey => $arrayValues) {
            if (isset($arrayValues[0])) {
                $this->tables[$numericKey] = (string) $arrayValues[0];
            }
        }
    }

    public function getAllTables()
    {
        return $this->tables;
    }
}
