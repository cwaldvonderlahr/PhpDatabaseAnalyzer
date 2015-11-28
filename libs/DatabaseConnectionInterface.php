<?php
namespace PhpDatabaseAnalyzer;

interface DatabaseConnnectionInterface
{

    public function __construct();

    public function set($host, $username, $password, $database, $port, $charset);

    public function getHost();

    public function getUsername();

    public function getPassword();

    public function getDatabase();
    
    public function getPort();
    
    public function getCharset();
    
    public function setHost();
    
    public function setUsername();
    
    public function setPassword();
    
    public function setDatabase();
    
    public function setPort();
    
    public function setCharset();
    
    public function query();
    
    public static function getInstance();
}
