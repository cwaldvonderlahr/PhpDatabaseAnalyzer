<?php
/**
* Logger interface
*
* @category  Interface
* @package   PhpDatabaseAnalyzer
* @author    Frederik Glücks <frederik@gluecks-online.de>
* @copyright Copyright (c) 2015
* @license   http://opensource.org/licenses/gpl-3.0.html GNU Public License
* @link      https://github.com/cwaldvonderlahr/PhpDatabaseAnalyzer
* @version   0.1
**/
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
