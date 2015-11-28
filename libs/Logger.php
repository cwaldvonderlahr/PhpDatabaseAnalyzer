<?php
namespace PhpDatabaseAnalyzer;

class Logger implements LoggerInterface
{

    private $loggingMode;

    public function __construct($loggingMode)
    {
        if ($loggingMode == 'issuses') {
            $this->loggingMode = $loggingMode;
        } else {
            $this->loggingMode = "full";
        }
    }

    public function setInfo($text)
    {
        /* do something */
    }

    public function setIssus($type, $text, $scorePoints)
    {
        /* do something */
    }

    public function getLog()
    {
        $log = array();

        $log[] = array(
            'timesstamp' => "",
            "text" => ""
        );

        return $log;
    }

    public function getIssuses()
    {
        $issuses = array();

        $issuses[] = array(
            'timestamp' => "",
            'type' => '',
            'text' => '',
            'scorePoints' => 0
        );

        return $issuses;
    }

    public function getQualityScore()
    {
        return 0;
    }
}
