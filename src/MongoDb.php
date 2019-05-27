<?php


namespace EasySwoole\MongoDb;


class MongoDb
{
    private $config;

    function __construct(Config $config)
    {
        $this->config = $config;
    }

    protected function client()
    {

    }
}