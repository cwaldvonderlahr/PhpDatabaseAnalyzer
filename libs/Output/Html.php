<?php
/**
 * Html Output Class
 *
 * @category  Output
 * @package   PhpDatabaseAnalyzer
 * @author    Frederik Glücks <frederik@gluecks-online.de>
 * @copyright Copyright (c) 2015
 * @license   http://opensource.org/licenses/gpl-3.0.html GNU Public License
 * @link      https://github.com/cwaldvonderlahr/PhpDatabaseAnalyzer
 * @version   0.1
 **/
namespace PhpDatabaseAnalyzer\Output;

class Html
{

    public function __construct()
    {
        /* do something */
    }

    public function create(\PhpDatabaseAnalyzer\Logger $Logger)
    {
        $DOM = new \DOMDocument(5, 'UTF-8');
        $DOM->formatOutput = true;

        $html = $DOM->createElement("html");
        $DOM->appendChild($html);

        $head = $DOM->createElement("head");
        $html->appendChild($head);

        $metaTitle = $DOM->createElement("title", "PhpDatabaseAnalyzer test result");
        $head->appendChild($metaTitle);


        $metaViewport = $DOM->createElement("meta");
        $head->appendChild($metaViewport);

        $classAttr = $DOM->createAttribute("name");
        $classAttr->value = 'viewport';
        $metaViewport->appendChild($classAttr);

        $classAttr = $DOM->createAttribute("content");
        $classAttr->value = 'width=device-width, initial-scale=1.0';
        $metaViewport->appendChild($classAttr);

        $this->addCss($DOM, $head, "https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css");

        $body = $DOM->createElement("body");
        $html->appendChild($body);

        $this->createHeadline($DOM, $body, $Logger);

        $this->createOverview($DOM, $body, $Logger);

        $this->createLogTable($DOM, $body, $Logger);

        return $DOM->saveHTML($html);
    }

    private function addCss($DOM, $head, $cssFile)
    {
        $link = $DOM->createElement("link");

        $relAttr = $DOM->createAttribute("rel");
        $relAttr->value = "stylesheet";
        $link->appendChild($relAttr);

        $hrefAttr = $DOM->createAttribute("href");
        $hrefAttr->value = $cssFile;
        $link->appendChild($hrefAttr);

        $head->appendChild($link);
    }

    private function createGrip($DOM, $body)
    {
        $container = $DOM->createElement("div");
        $classAttr = $DOM->createAttribute("class");
        $classAttr->value = 'container';
        $container->appendChild($classAttr);
        $body->appendChild($container);

        $row = $DOM->createElement("div");
        $classAttr = $DOM->createAttribute("class");
        $classAttr->value = 'row';
        $row->appendChild($classAttr);
        $container->appendChild($row);

        $col = $DOM->createElement("div");
        $classAttr = $DOM->createAttribute("class");
        $classAttr->value = 'col-md-12';
        $col->appendChild($classAttr);
        $row->appendChild($col);

        return $col;
    }

    private function createHeadline($DOM, $body, $Logger)
    {
        $container = $this->createGrip($DOM, $body);

        $h1 = $DOM->createElement("h1", "PhpDatabaseAnalyzer test result");
        $container->appendChild($h1);

        $p = $DOM->createElement("p", date('Y-m-d H:i'));

        $classAttr = $DOM->createAttribute("class");
        $classAttr->value = 'text-right';
        $p->appendChild($classAttr);

        $container->appendChild($p);

        return $Logger;
    }

    private function createOverview($DOM, $body, $Logger)
    {
        $container = $this->createGrip($DOM, $body);

        $table = $this->createTableNode($DOM, $container);

        $tbody = $DOM->createElement("tbody");
        $table->appendChild($tbody);

        /* overview */

        $tests = 0;
        $notices = 0;
        $warnings = 0;
        $critical = 0;
        $scorePoints = 0;

        foreach ($Logger->getLog() as $logEntry) {
            if ($logEntry['logType'] == 'info' && substr($logEntry['text'], 0, 6) == 'Start ') {
                $tests ++;
            } elseif ($logEntry['logType'] == 'issue') {
                if ($logEntry['issueType'] == 'notice') {
                    $notices ++;
                } elseif ($logEntry['issueType'] == 'warning') {
                    $warnings ++;
                } elseif ($logEntry['issueType'] == 'critical') {
                    $critical ++;
                }

                $scorePoints += $logEntry['scorePoints'];
            }
        }

        /* total test */

        $tr = $DOM->createElement("tr");
        $tbody->appendChild($tr);

        $this->addTableCell($DOM, $tr, "Total tests");
        $this->addTableCell($DOM, $tr, $tests);

        /* total notice */

        $tr = $DOM->createElement("tr");
        $tbody->appendChild($tr);

        $this->addTableCell($DOM, $tr, "Total notices");
        $this->addTableCell($DOM, $tr, $notices);

        /* total warnings */

        $tr = $DOM->createElement("tr");
        $tbody->appendChild($tr);

        $this->addTableCell($DOM, $tr, "Total warnings");
        $this->addTableCell($DOM, $tr, $warnings);

        /* total critical */

        $tr = $DOM->createElement("tr");
        $tbody->appendChild($tr);

        $this->addTableCell($DOM, $tr, "Total critical");
        $this->addTableCell($DOM, $tr, $critical);

        /* total score */

        $tr = $DOM->createElement("tr");
        $tbody->appendChild($tr);

        $this->addTableCell($DOM, $tr, "Score");
        $this->addTableCell($DOM, $tr, $scorePoints);
    }

    private function createLogTable($DOM, $body, $Logger)
    {
        $container = $this->createGrip($DOM, $body);

        $table = $this->createTableNode($DOM, $container);

        $this->createLogTableHeader($DOM, $table);

        $this->createTableBody($DOM, $table, $Logger);
    }

    private function createLogTableHeader($DOM, $table)
    {
        $thead = $DOM->createElement("thead");
        $table->appendChild($thead);

        $tr = $DOM->createElement("tr");
        $thead->appendChild($tr);

        $this->addTableCell($DOM, $tr, "Timestamp");

        $this->addTableCell($DOM, $tr, "Type");

        $this->addTableCell($DOM, $tr, "Message");

        $this->addTableCell($DOM, $tr, "Score", "text-center");
    }

    private function addLogTypeCssClass($DOM, $node, $logType)
    {
        $classAttr = $DOM->createAttribute("class");
        $node->appendChild($classAttr);

        switch ($logType) {
            case 'critical':
                $classAttr->value = 'danager';
                break;

            case 'warning':
                $classAttr->value = 'warning';
                break;

            case 'notice':
                $classAttr->value = 'info';
                break;

            default:
                $classAttr->value = '';
        }
    }

    private function createTableBody($DOM, $table, $Logger)
    {
        $tbody = $DOM->createElement("tbody");
        $table->appendChild($tbody);

        foreach ($Logger->getLog() as $logEntry) {
            $tr = $DOM->createElement("tr");
            $tbody->appendChild($tr);
            $this->addLogTypeCssClass($DOM, $tr, $logEntry['issueType']);

            $this->addTableCell($DOM, $tr, date("Y-m-d H:i:s", $logEntry['timestamp']));

            if ($logEntry['logType'] == 'issue') {
                $this->addTableCell($DOM, $tr, $logEntry['logType'] . " - " . $logEntry['issueType']);
            } else {
                $this->addTableCell($DOM, $tr, $logEntry['logType']);
            }

            $this->addTableCell($DOM, $tr, $logEntry['text']);
            $this->addTableCell($DOM, $tr, $logEntry['scorePoints'], "text-center");
        }
    }

    private function addTableCell($DOM, $tr, $value, $cssClass = "")
    {
        $td = $DOM->createElement("td", $value);
        $tr->appendChild($td);

        if (! empty($cssClass) && is_string($cssClass)) {
            $classAttr = $DOM->createAttribute("class");
            $classAttr->value = $cssClass;
            $td->appendChild($classAttr);
        }
    }

    private function createTableNode($DOM, $parentNode)
    {
        $table = $DOM->createElement("table");
        $parentNode->appendChild($table);

        $classAttr = $DOM->createAttribute("class");
        $classAttr->value = 'table table-hover table-striped';
        $table->appendChild($classAttr);

        return $table;
    }
}
