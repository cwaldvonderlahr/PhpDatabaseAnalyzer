<?php
namespace PhpDatabaseAnalyzer\Output;

interface OutputInterface
{

    public function __construct();

    public function create(\PhpDatabaseAnalyzer\Logger $Logger);
}
