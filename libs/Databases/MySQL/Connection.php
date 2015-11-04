<?php
namespace Databases\Mysql;

class Connection
{

    protected $mysqli;

    protected $host;

    protected $username;

    protected $password;

    protected $database;

    protected $port;

    protected $charset;

    public function __construct()
    {}

    public function set($host, $username, $password, $database, $port = false, $charset = false)
    {
        $this->setHost($host);
        $this->setUsername($username);
        $this->setPassword($password);
        $this->setDatabase($database);
        $this->setPort($port);
        $this->setCharset($charset);
        
        $this->mysqli = new \mysqli($this->host, $this->username, $this->password, $this->database, $this->port);
        
        if ($this->mysqli->connect_error) {
            throw new \Exception('Connection Error ' . $this->mysqli->connect_errno . ': ' . $this->mysqli->connect_error);
        }
        if (isset($this->charset) and $this->charset !== false) {
            $this->mysqli->set_charset($this->charset);
        }
        
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
        $this->host = $host;
    }

    /**
     *
     * @param string $username            
     */
    public function setUsername($username)
    {
        $this->username = $username;
    }

    /**
     *
     * @param string $password            
     */
    public function setPassword($password)
    {
        $this->password = $password;
    }

    /**
     *
     * @param string $database            
     */
    public function setDatabase($database)
    {
        $this->database = $database;
    }

    /**
     *
     * @param int $port            
     */
    public function setPort($port)
    {
        if ($port === false) {
            $port = (int) 3306;
        }
        
        $port = (int) $port;
    	
        $this->port = $port;
    }

    /**
     *
     * @param string $charset            
     */
    public function setCharset($charset)
    {
        $this->charset = $charset;
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
}
