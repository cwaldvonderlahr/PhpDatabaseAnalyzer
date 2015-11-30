<?php
/**
 * Xml Output Class
 *
 * @category  Output
 * @package   PhpDatabaseAnalyzer
 * @author    ironchrissi <mail@ironchrissi.de>
 * @copyright Copyright (c) 2015
 * @license   http://opensource.org/licenses/gpl-3.0.html GNU Public License
 * @link      https://github.com/ironchrissi/PhpDatabaseAnalyzer
 * @version   0.1
 **/
namespace PhpDatabaseAnalyzer\Output;

class Xml implements OutputInterface
{

    public function __construct()
    {
        /* do something */
    }

    public function create(\PhpDatabaseAnalyzer\Logger $Logger)
    {
        $dom = new \DOMDocument('1.0', 'UTF-8');
        $dom->formatOutput = true;

        $root = $dom->createElement("PhpDatabaseAnalyzerLog");
        $dom->appendChild($root);

        foreach ($Logger->getLog() as $logEntry) {
            $line = $dom->createElement("line");
            $root->appendChild($line);

            foreach ($logEntry as $fieldName => $fieldValue) {
                if ($fieldName == 'timestamp') {
                    $fieldValue = date("Y-m-d H:i:s", $fieldValue);
                }

                $field = $dom->createElement($fieldName, $fieldValue);
                $line->appendChild($field);
            }
        }

        print $dom->saveXML($root);
    }
}
