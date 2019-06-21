<?php
/**
 * DatabaseConnection interface
 *
 * @category  Interface
 * @package   PhpDatabaseAnalyzer
 * @author    Christian Wald-von der Lahr <dev@wald-vonderlahr.de>
 * @copyright Copyright (c) 2015
 * @license   http://opensource.org/licenses/gpl-3.0.html GNU Public License
 * @link      https://github.com/cwaldvonderlahr/PhpDatabaseAnalyzer
 * @version   0.1
 **/
namespace PhpDatabaseAnalyzer;

/**
 * DatabaseConnection interface
 * 
 * @author Christian Wald-von der Lahr <dev@wald-vonderlahr.de>
 *
 */
interface DatabaseConnectionInterface
{

    /**
     * default construct
     */
    public function __construct();

    /**
     * set mysqli database connection
     * 
     * @param string $host
     * @param string $username
     * @param string $password
     * @param string $database
     * @param integer $port
     * @param string $socket
     * @param string $charset
     * 
     * @throws \Exception
     * @return boolean
     */
    public function set($host, $username, $password, $database, $port, $socket, $charset);

    /**
     * get the host of the current database connection
     * 
     * @return string
     */
    public function getHost();

    /**
     * get the user of the current database connection
     * 
     * @return string
     */
    public function getUsername();

    /**
     * get the password of the current database connection
     * 
     * @return string
     */
    public function getPassword();

    /**
     * get the database name of the current database connection
     *
     * @return string
     */
    public function getDatabase();

    /**
     * get the port of the current database connection
     *
     * @return integer
     */
    public function getPort();
    
    /**
     * get the socket of the current database connection
     *
     * @return string
     */
    public function getSocket();

    /**
     * get the charset of the current database connection
     *
     * @return string
     */
    public function getCharset();

    /**
     * set the host to prepare the database connection set
     * 
     * @param string $host
     *
     * @return boolean
     */
    public function setHost($host);

    /**
     * set the username to prepare the database connection set
     * 
     * @param string $username
     *
     * @return boolean
     */
    public function setUsername($username);

    /**
     * set the password to prepare the database connection set
     * 
     * @param string $password
     *
     * @return boolean
     */
    public function setPassword($password);

    /**
     * set the database name to prepare the database connection set
     * 
     * @param string $database
     *
     * @return boolean
     */
    public function setDatabase($database);

    /**
     * set the port to prepare the database connection set (default Port: 3306)
     * 
     * @param integer $port
     * 
     * @return boolean
     */
    public function setPort($port);
    
    /**
     * set the socket to prepare the database connection set (default: empty)
     * 
     * @param string $socket
     *
     * @return boolean
     */
    public function setSocket($socket);

    /**
     * set the charset to prepare the database connection set (default: empty)
     * 
     * @param string $charset
     *
     * @return boolean
     */
    public function setCharset($charset);

    /**
     * perform a query and return the result object
     * 
     * @param string $query
     *
     * @return object
     */
    public function query($query);

    /**
     * perform a query and return the result as an array
     *
     * @param string $query
     * @param string $arrayType (assoc or num)
     * @return array
     */
    public function getArray($query);

    /**
     * perform a query and return the result row as an array
     *
     * @param string $query
     * @return array
     */
    public function getRow($query);

    /**
     * return the current database class object
     */
    public static function getInstance();
}
