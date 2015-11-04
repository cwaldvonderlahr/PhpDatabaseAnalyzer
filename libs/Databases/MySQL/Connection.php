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
    {
    }

    public function set($host, $username, $password, $database, $port, $charset)
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
        if ($this->charset) {
            $this->mysqli->set_charset($this->charset);
        }
        
        return true;
    }
    /**
     * @return the $mysqli
     */
    public function getMysqli()
    {
        return $this->mysqli;
    }

    /**
     * @return the $host
     */
    public function getHost()
    {
        return $this->host;
    }

    /**
     * @return the $username
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * @return the $password
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @return the $database
     */
    public function getDatabase()
    {
        return $this->database;
    }

    /**
     * @return the $port
     */
    public function getPort()
    {
        return $this->port;
    }

    /**
     * @return the $charset
     */
    public function getCharset()
    {
        return $this->charset;
    }

    /**
     * @param \mysqli $mysqli
     */
    public function setMysqli($mysqli)
    {
        $this->mysqli = $mysqli;
    }

    /**
     * @param field_type $host
     */
    public function setHost($host)
    {
        $this->host = $host;
    }

    /**
     * @param field_type $username
     */
    public function setUsername($username)
    {
        $this->username = $username;
    }

    /**
     * @param field_type $password
     */
    public function setPassword($password)
    {
        $this->password = $password;
    }

    /**
     * @param field_type $database
     */
    public function setDatabase($database)
    {
        $this->database = $database;
    }

    /**
     * @param field_type $port
     */
    public function setPort($port)
    {
        $this->port = $port;
    }

    /**
     * @param field_type $charset
     */
    public function setCharset($charset)
    {
        $this->charset = $charset;
    }
    
    public function query($query) {
        return $this->mysqli->query($query);
    }
}
