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


/**
 * Mysqli Connection Class
 * 
 * @author Christian Wald-von der Lahr <dev@wald-vonderlahr.de>
 *
 */
class Connection implements \PhpDatabaseAnalyzer\DatabaseConnectionInterface
{
    /**
     * @var object mysqli Object
     * @var string $host mysqli host (IP Adresse or Hostname)
     * @var string $username mysqli username
     * @var string password mysqli password
     * @var string $database mysqli database
     * @var string $port mysqli port
     * @var string $socket mysqli socket
     * @var string $charset mysqli charset
     */
    protected $mysqli, $host, $username, $password, $database, $port, $socket, $charset;

    /**
     * @var object $instance mysqli current instance
     */
    private static $instance;

    /**
     * default construct
     */
    public function __construct()
    {
        /* do something if neccessary */
    }

    /**
     * {@inheritDoc}
     * @see \PhpDatabaseAnalyzer\DatabaseConnectionInterface::set()
     * 
     * @param string $host
     * @param string $username
     * @param string $password
     * @param string $database
     * @param integer $port
     * @param string $socket
     * @param string $charset
     */
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
     * {@inheritDoc}
     * @see \PhpDatabaseAnalyzer\DatabaseConnectionInterface::getHost()
     */
    public function getHost()
    {
        return $this->host;
    }

    /**
     * {@inheritDoc}
     * @see \PhpDatabaseAnalyzer\DatabaseConnectionInterface::getUsername()
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * {@inheritDoc}
     * @see \PhpDatabaseAnalyzer\DatabaseConnectionInterface::getPassword()
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * {@inheritDoc}
     * @see \PhpDatabaseAnalyzer\DatabaseConnectionInterface::getDatabase()
     */
    public function getDatabase()
    {
        return $this->database;
    }

    /**
     * {@inheritDoc}
     * @see \PhpDatabaseAnalyzer\DatabaseConnectionInterface::getPort()
     */
    public function getPort()
    {
        return $this->port;
    }
    
    /**
     * {@inheritDoc}
     * @see \PhpDatabaseAnalyzer\DatabaseConnectionInterface::getSocket()
     */
    public function getSocket()
    {
        return $this->socket;
    }

    /**
     * {@inheritDoc}
     * @see \PhpDatabaseAnalyzer\DatabaseConnectionInterface::getCharset()
     */
    public function getCharset()
    {
        return $this->charset;
    }
    
    /**
     * {@inheritDoc}
     * @see \PhpDatabaseAnalyzer\DatabaseConnectionInterface::setHost()
     * 
     * @param string $host
     * 
     * @return boolean
     */
    public function setHost($host)
    {
        if (! isset($host) || empty($host)) {
            throw new \Exception("Empty Host");
        }
        
        $this->host = (string) $host;
        
        return true;
    }

    /**
     * {@inheritDoc}
     * @see \PhpDatabaseAnalyzer\DatabaseConnectionInterface::setUsername()
     * 
     * @param string $username
     * 
     * @return boolean
     */
    public function setUsername($username)
    {
        if (! isset($username) || empty($username)) {
            throw new \Exception("Empty Username");
        }
        
        $this->username = (string) $username;
        
        return true;
    }

    /**
     * {@inheritDoc}
     * @see \PhpDatabaseAnalyzer\DatabaseConnectionInterface::setPassword()
     * 
     * @param string $password
     * 
     * @return boolean
     */
    public function setPassword($password)
    {
        $this->password = (string) $password;
        
        return true;
    }

    /**
     * {@inheritDoc}
     * @see \PhpDatabaseAnalyzer\DatabaseConnectionInterface::setDatabase()
     * 
     * @param string $database
     * 
     * @return boolean
     */
    public function setDatabase($database)
    {
        if (! isset($database) || empty($database)) {
            throw new \Exception("Empty Database");
        }
        
        $this->database = (string) $database;
        
        return true;
    }

    /**
     * {@inheritDoc}
     * @see \PhpDatabaseAnalyzer\DatabaseConnectionInterface::setPort()
     * 
     * @param integer $port
     * 
     * @return boolean
     */
    public function setPort($port)
    {
        if (! isset($port) || empty($port) || $port === 0) {
            $port = (int) 3306;
        }
        
        $this->port = (int) $port;
        
        return true;
    }
    
    /**
     * {@inheritDoc}
     * @see \PhpDatabaseAnalyzer\DatabaseConnectionInterface::setSocket()
     * 
     * @param string $socket
     * 
     * @return boolean
     */
    public function setSocket($socket)
    {
        if (! isset($socket) || empty($socket) || !is_string($socket)) {
            $socket = "";
        }
    
        $this->socket = $socket;
        
        return true;
    }

    /**
     * {@inheritDoc}
     * @see \PhpDatabaseAnalyzer\DatabaseConnectionInterface::setCharset()
     * 
     * @param string $charset
     * 
     * @return boolean
     */
    public function setCharset($charset)
    {
        if (! isset($charset) || empty($charset)) {
            $charset = "";
        }
        
        $this->charset = (string) $charset;
        
        return true;
    }

    /**
     * {@inheritDoc}
     * @see \PhpDatabaseAnalyzer\DatabaseConnectionInterface::query()
     * 
     * @param string $query
     * 
     * @return object
     */
    public function query($query)
    {
        return $this->mysqli->query($query);
    }

    /**
     * {@inheritDoc}
     * @see \PhpDatabaseAnalyzer\DatabaseConnectionInterface::getArray()
     * 
     * @param string $query
     * @param string $arrayType
     * 
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
     * {@inheritDoc}
     * @see \PhpDatabaseAnalyzer\DatabaseConnectionInterface::getRow()
     * 
     * @param string $query
     * 
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
     * {@inheritDoc}
     * @see \PhpDatabaseAnalyzer\DatabaseConnectionInterface::getRow()
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
