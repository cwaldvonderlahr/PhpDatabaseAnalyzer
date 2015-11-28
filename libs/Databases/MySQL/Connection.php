<?php
/**
 * Mysqli Connection Class
 *
 * @category  Database
 * @package   PhpDatabaseAnalyzer
 * @author    ironchrissi <mail@ironchrissi.de>
 * @copyright Copyright (c) 2015
 * @license   http://opensource.org/licenses/gpl-3.0.html GNU Public License
 * @link      https://github.com/ironchrissi/PhpDatabaseAnalyzer
 * @version   0.1
 **/
namespace PhpDatabaseAnalyzer\Databases\Mysql;

class Connection implements DatabaseConnnectionInterface
{

    protected $mysqli;

    protected $host;

    protected $username;

    protected $password;

    protected $database;

    protected $port;

    protected $charset;

    private static $instance;

    public function __construct()
    {
        /* do something */
    }

    public function set($host, $username, $password, $database, $port = 0, $charset = "")
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
        if (isset($this->charset) and ! empty($this->charset)) {
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
        if (! isset($host) or empty($host)) {
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
        if (! isset($username) or empty($username)) {
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
        if (! isset($database) or empty($database)) {
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
        if (! isset($port) or empty($port) or $port === 0) {
            $port = (int) 3306;
        }
        
        $this->port = (int) $port;
    }

    /**
     *
     * @param string $charset
     */
    public function setCharset($charset)
    {
        if (! isset($charset) or empty($charset)) {
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
