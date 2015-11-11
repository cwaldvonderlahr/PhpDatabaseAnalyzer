<?php
namespace PhpDatabaseAnalyzer;

interface PhpDatabaseAnalyzerInterface
{

    public function __construct($configFile);

    public function start();
}
