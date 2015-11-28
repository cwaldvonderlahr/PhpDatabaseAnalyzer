<?php
namespace PhpDatabaseAnalyzer;

interface LoggerInterface
{

    public function __construct($loggingMode);

    public function setInfo($text);

    public function setIssus($type, $text, $scorePoints);

    public function getLog();

    public function getIssuses();

    public function getQualityScore();
}
