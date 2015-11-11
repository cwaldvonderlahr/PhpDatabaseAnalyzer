<?php
namespace PhpDatabaseAnalyzer;

interface ConfigInterface
{

    public function __construct($configFileName);

    public function getOutputType();

    public function getDatabaseTestSuiteAsList();

    public function getConnectionParametersOfDatabaseTestSuite($positionInList);
}
