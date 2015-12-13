<?php
/**
 * Config Class
 *
 * @category  Config
 * @package   PhpDatabaseAnalyzer
 * @author    Frederik Glücks <frederik@gluecks-online.de>
 * @copyright Copyright (c) 2015
 * @license   http://opensource.org/licenses/gpl-3.0.html GNU Public License
 * @link      https://github.com/cwaldvonderlahr/PhpDatabaseAnalyzer
 * @version   0.1
 **/
namespace PhpDatabaseAnalyzer;

/**
 *
 * @author fgluecks
 *
 */
class Config implements ConfigInterface
{

    private $xmlConfigObject;

    /**
     *
     * @param string $configFile
     */
    public function __construct($configFile)
    {
        $this->loadConfig($configFile);
    }

    private function loadConfig($configFile)
    {
        if (! is_file($configFile)) {
            throw new \InvalidArgumentException("Config file does not exists", E_ERROR);
        } else {
            $this->xmlConfigObject = simplexml_load_file($configFile);

            if (! is_object($this->xmlConfigObject) || $this->xmlConfigObject->getName() != 'phpDatabaseAnalyzer') {
                throw new \InvalidArgumentException("Invalid config file", E_ERROR);
            } else {
                return true;
            }
        }
    }

    /**
     *
     * {@inheritDoc}
     *
     * @see \PhpDatabaseAnalyzer\ConfigInterface::getOutputType()
     */
    public function getOutputType()
    {
        if (! isset($this->xmlConfigObject->outputType)) {
            throw new \RuntimeException("outputType does not exist in XML config", E_ERROR);
        } else {
            return $this->xmlConfigObject->outputType->__toString();
        }
    }

    /**
     *
     * {@inheritDoc}
     *
     * @see \PhpDatabaseAnalyzer\ConfigInterface::getLoggingMode()
     */
    public function getLoggingMode()
    {
        if (! isset($this->xmlConfigObject->loggingMode)) {
            throw new \RuntimeException("loggingMode does not exist in XML config", E_ERROR);
        } else {
            return $this->xmlConfigObject->loggingMode->__toString();
        }
    }

    /**
     *
     * {@inheritDoc}
     *
     * @see \PhpDatabaseAnalyzer\ConfigInterface::getDatabaseTestSuiteAsList()
     */
    public function getDatabaseTestSuiteAsList()
    {
        if (! isset($this->xmlConfigObject->databaseTestSuite)) {
            throw new \RuntimeException("databaseTestSuite does not exist in XML config", E_ERROR);
        } else {
            $databaseTestSuiteList = array();
            $positionKey = 0;

            foreach ($this->xmlConfigObject->databaseTestSuite as $databaseTestSuite) {
                $databaseTestSuiteList[] = $positionKey;
                $positionKey ++;
            }
            return $databaseTestSuiteList;
        }
    }

    /**
     *
     * {@inheritDoc}
     *
     * @see \PhpDatabaseAnalyzer\ConfigInterface::getConnectionParametersOfDatabaseTestSuite()
     */
    public function getConnectionParametersOfDatabaseTestSuite($positionInList)
    {
        if (! isset($this->xmlConfigObject->databaseTestSuite[$positionInList])) {
            throw new \RuntimeException("databaseTestSuite does not exist in XML config", E_ERROR);
        } else {
            $connectionParameter = array(
                'engine' => $this->xmlConfigObject->databaseTestSuite[$positionInList]['databaseEngine']->__toString(),
                'host' => $this->xmlConfigObject->databaseTestSuite[$positionInList]->connection->host->__toString(),
                'port' => $this->xmlConfigObject->databaseTestSuite[$positionInList]->connection->port->__toString(),
                'socket' => $this->xmlConfigObject->databaseTestSuite[$positionInList]->connection->socket->__toString(),
                'username' => $this->xmlConfigObject->databaseTestSuite[$positionInList]->connection->username->__toString(),
                'password' => $this->xmlConfigObject->databaseTestSuite[$positionInList]->connection->password->__toString(),
                'database' => $this->xmlConfigObject->databaseTestSuite[$positionInList]->connection->database->__toString()
            );
            return $connectionParameter;
        }
    }
}
