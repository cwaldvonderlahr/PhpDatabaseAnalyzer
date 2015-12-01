<?php
namespace PhpDatabaseAnalyzer;

interface DatabaseConnectionInterface
{

    public function __construct();
	
    public function set($host, $username, $password, $database, $port, $charset);
	
    public function getHost();
	
    public function getUsername();
	
    public function getPassword();
	
    public function getDatabase();
    
    public function getPort();
    
    public function getCharset();
    
    public function setHost($host);
    
    public function setUsername($username);
    
    public function setPassword($password);
    
    public function setDatabase($database);
    
    public function setPort($port);
    
    public function setCharset($charset);
    
    public function query($query);
    
    public function getArray($query);
    
    public function getRow($query);
    
    public static function getInstance();
}
