<?php
/**
 * Html Output Class
 *
 * @category  Output
 * @package   PhpDatabaseAnalyzer
 * @author    Frederik Glücks <frederik@gluecks-online.de>
 * @copyright Copyright (c) 2015
 * @license   http://opensource.org/licenses/gpl-3.0.html GNU Public License
 * @link      https://github.com/ironchrissi/PhpDatabaseAnalyzer
 * @version   0.1
 **/
namespace PhpDatabaseAnalyzer\Output;

class Html
{

    public function __construct()
    {
        /* do something */
    }
    
    private function addCss(&$dom, &$head, $cssFile)
    {
        $link = $dom->createElement("link");
        
        $relAttr = $dom->createAttribute("rel");
        $relAttr->value = "stylesheet";
        $link->appendChild($relAttr);
        
        $hrefAttr = $dom->createAttribute("href");
        $hrefAttr->value = $cssFile;
        $link->appendChild($hrefAttr);
        
        $head->appendChild($link);
    }
    

    public function create(\PhpDatabaseAnalyzer\Logger $Logger)
    {
        $dom = new \DOMDocument(5, 'UTF-8');
        $dom->formatOutput = true;
    
        $html = $dom->createElement("html");
        $dom->appendChild($html);
        
        $head = $dom->createElement("head");
        $html->appendChild($head);
        
        $this->addCss($dom, $head, "https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css");
        
        $body = $dom->createElement("body");
        $html->appendChild($body);
    
        $table = $dom->createElement("table");
        $body->appendChild($table);
        
        $classAttr = $dom->createAttribute("class");
        $classAttr->value = 'table';
        $table->appendChild($classAttr);
        
        $tbody = $dom->createElement("tbody");
        $table->appendChild($tbody);
        
        foreach ($Logger->getLog() as $logEntry) {
            $tr = $dom->createElement("tr");
    
            foreach ($logEntry as $fieldName => $fieldValue) {
                if ($fieldName == 'timestamp') {
                    $fieldValue = date("Y-m-d H:i:s", $fieldValue);
                }
    
                $td = $dom->createElement("td", $fieldValue);
                $tr->appendChild($td);
            }+
            $tbody->appendChild($tr);
            
        }
    
        header("Content-type: text/html");
        print $dom->saveHTML($html);
    }
}
