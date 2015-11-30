<?php
/**
 * Autoloader
 */
$loader = require dirname(__FILE__) . '/../vendor/autoload.php';

/**
 * run database analyzer
 */

if (! isset($argv[1])) {
    $argv[1] = "";
}

$PhpDatabaseAnalyzer = new \PhpDatabaseAnalyzer\PhpDatabaseAnalyzer($argv[1]);

$PhpDatabaseAnalyzer->start();
