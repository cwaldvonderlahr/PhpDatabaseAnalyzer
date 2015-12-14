<?php
/**
 * Mysqli Connection Class
 *
 * @category  Database
 * @package   PhpDatabaseAnalyzer
 * @author    Christian Wald-von der Lahr <dev@wald-vonderlahr.de>
 * @copyright Copyright (c) 2015
 * @license   http://opensource.org/licenses/gpl-3.0.html GNU Public License
 * @link      https://github.com/cwaldvonderlahr/PhpDatabaseAnalyzer
 * @version   0.1
 **/
namespace PhpDatabaseAnalyzer\Databases\Mysql;

class Connection implements \PhpDatabaseAnalyzer\DatabaseConnectionInterface
{

    protected $mysqli;

    protected $host;

    protected $username;

    protected $password;

    protected $database;

    protected $port;

    protected $socket;

    protected $charset;

    private static $instance;

    public function __construct()
    {
        /* do something */
    }

    public function set($host, $username, $password, $database, $port = 0, $socket = "", $charset = "")
    {
        $this->setHost($host);
        $this->setUsername($username);
        $this->setPassword($password);
        $this->setDatabase($database);
        $this->setPort($port);
        $this->setCharset($charset);
        $this->setSocket($socket);
        
        $this->mysqli = new \mysqli($this->getHost(), $this->getUsername(), $this->getPassword(), $this->getDatabase(), $this->getPort(), $this->getSocket());
        
        if ($this->mysqli->connect_error) {
            throw new \Exception('Connection Error ' . $this->mysqli->connect_errno . ': ' . $this->mysqli->connect_error);
        }
        if (isset($this->charset) && ! empty($this->charset)) {
            $this->mysqli->set_charset($this->charset);
        }
        
        self::$instance = $this;
        
        return true;
    }

    /**
     *
     * @return the $mysqli
     */
    public function getMysqli()
    {
        return $this->mysqli;
    }

    /**
     *
     * @return the $host
     */
    public function getHost()
    {
        return $this->host;
    }

    /**
     *
     * @return the $username
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     *
     * @return the $password
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     *
     * @return the $database
     */
    public function getDatabase()
    {
        return $this->database;
    }

    /**
     *
     * @return the $port
     */
    public function getPort()
    {
        return $this->port;
    }
    
    /**
     *
     * @return the $socket
     */
    public function getSocket()
    {
        return $this->socket;
    }

    /**
     *
     * @return the $charset
     */
    public function getCharset()
    {
        return $this->charset;
    }

    /**
     *
     * @param \mysqli $mysqli
     */
    public function setMysqli($mysqli)
    {
        $this->mysqli = $mysqli;
    }

    /**
     *
     * @param string $host
     */
    public function setHost($host)
    {
        if (! isset($host) || empty($host)) {
            throw new \Exception("Empty Host");
        }
        
        $this->host = (string) $host;
    }

    /**
     *
     * @param string $username
     */
    public function setUsername($username)
    {
        if (! isset($username) || empty($username)) {
            throw new \Exception("Empty Username");
        }
        
        $this->username = (string) $username;
    }

    /**
     *
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->password = (string) $password;
    }

    /**
     *
     * @param string $database
     */
    public function setDatabase($database)
    {
        if (! isset($database) || empty($database)) {
            throw new \Exception("Empty Database");
        }
        
        $this->database = (string) $database;
    }

    /**
     *
     * @param int $port
     */
    public function setPort($port)
    {
        if (! isset($port) || empty($port) || $port === 0) {
            $port = (int) 3306;
        }
        
        $this->port = (int) $port;
    }
    
    /**
     *
     * @param int $socket
     */
    public function setSocket($socket)
    {
        if (! isset($socket) || empty($socket) || !is_string($socket)) {
            $socket = "";
        }
    
        $this->socket = $socket;
    }

    /**
     *
     * @param string $charset
     */
    public function setCharset($charset)
    {
        if (! isset($charset) || empty($charset)) {
            $charset = "";
        }
        
        $this->charset = (string) $charset;
    }

    /**
     *
     * @param string $query
     * @return object
     */
    public function query($query)
    {
        return $this->mysqli->query($query);
    }

    /**
     *
     * @param string $query
     * @param string $arrayType
     *            (assoc or num)
     * @return array
     */
    public function getArray($query, $arrayType = 'num')
    {
        $result = $this->query($query);
        
        $fetchArrayType = MYSQLI_NUM;
        if ($arrayType == "assoc") {
            $fetchArrayType = MYSQLI_ASSOC;
        }
        
        $returnArray = $result->fetch_all($fetchArrayType);
        
        $result->free();
        unset($result, $query);
        
        return $returnArray;
    }

    /**
     *
     * @param string $query
     * @return array
     */
    public function getRow($query)
    {
        $result = $this->query($query);
        
        $return = $result->fetch_row();
        
        $result->free();
        
        unset($result, $query);
        
        return $return;
    }

    /**
     *
     * @return \PhpDatabaseAnalyzer\Databases\Mysql\Connection
     */
    public static function getInstance()
    {
        if (! isset(self::$instance)) {
            self::$instance = new Connection();
        }
        
        return self::$instance;
    }
}
