<?php
namespace PhpDatabaseAnalyzer;

interface LoggerInterface
{

    public function __construct($loggingMode);

    public function setInfo($text);

    public function setIssue($type, $text, $scorePoints);

    public function getLog();

    public function getIssues();

    public function getQualityScore();
}
