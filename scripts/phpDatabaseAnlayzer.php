<?php
/**
 * Autoloader
 */

$loader = require dirname(__FILE__).'/../vendor/autoload.php';

/**
 * run database analyzer
 */

$PhpDatabaseAnalyzer = new \PhpDatabaseAnalyzer\PhpDatabaseAnalyzer($argv[1]);

$PhpDatabaseAnalyzer->start();
