<?php
namespace EasySwoole\MongoDb;

use EasySwoole\MongoDb\Exception\ConfigException;
use EasySwoole\Spl\SplBean;

class Config extends SplBean
{
    /**
     * @var string
     */
    private $hostname;

    /**
     * @return string
     */
    public function getHostname (): string
    {
        return $this->hostname;
    }

    /**
     * @param string $hostname
     * @throws ConfigException
     */
    public function setHostname (string $hostname): void
    {
        $hostname = trim($hostname);
        if (! preg_match('/^(.*:[\d]+)$/', $hostname) === 1) {
            throw new ConfigException("Hostname format is 'host:port'.");
        }
        $this->hostname = $hostname;
    }
}
