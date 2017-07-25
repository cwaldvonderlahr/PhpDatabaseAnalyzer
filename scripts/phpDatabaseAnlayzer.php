<?php
/**
 * Autoloader
 */
$loader = require dirname(__FILE__) . '/../vendor/autoload.php';

/**
 * Timezone
 */

date_default_timezone_set('Europe/Berlin');

/**
 * run database analyzer
 */

if (! isset($argv[1])) {
    $argv[1] = "";
}

$PhpDatabaseAnalyzer = new \PhpDatabaseAnalyzer\PhpDatabaseAnalyzer($argv[1]);

print $PhpDatabaseAnalyzer->start();
