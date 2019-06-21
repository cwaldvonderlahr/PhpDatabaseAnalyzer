<?php
/**
 * DatabaseConnection interface
 *
 * @category  Interface
 * @package   PhpDatabaseAnalyzer
 * @author    Frederik Glücks <frederik.gluecks@conftec.de>
 * @copyright Copyright (c) 2017
 * @license   http://opensource.org/licenses/gpl-3.0.html GNU Public License
 * @link      https://github.com/conftec/PhpDatabaseAnalyzer
 * @version   0.1
 **/
namespace PhpDatabaseAnalyzer;

interface DatabaseStructureInterface
{

    public function __construct(\PhpDatabaseAnalyzer\Databases\Mysql\Connection $Connection);

    public function getAllTables();
}
