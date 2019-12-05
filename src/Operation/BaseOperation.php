<?php
/**
 * Created by PhpStorm.
 * User: Manlin
 * Date: 2019/11/22
 * Time: 5:31 下午
 */
namespace EasySwoole\MongoDb\Operation;

use EasySwoole\MongoDb\Broker;
use EasySwoole\MongoDb\Config;
use EasySwoole\MongoDb\Protocol;

class BaseOperation
{
    /**
     * @var Broker
     */
    private $broker;

    /**
     * @var Config
     */
    private $config;

    public function __construct(Config $config)
    {
        $this->setConfig($config);

        Protocol::init(0);
    }

    /**
     * @return Broker
     */
    protected function getBroker(): Broker
    {
        if ($this->broker === null) {
            $this->broker = new Broker();
        }
        return $this->broker;
    }

    /**
     * @return Config
     */
    public function getConfig (): Config
    {
        if ($this->config === null) {
            $this->config = new Config();
        }
        return $this->config;
    }

    /**
     * @param Config $config
     */
    public function setConfig (Config $config): void
    {
        $this->config = $config;
    }
}
