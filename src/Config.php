<?php


namespace EasySwoole\MongoDb;


use EasySwoole\Spl\SplBean;

class Config extends SplBean
{
    protected $workerNum = 3;
    protected $timeout = 3;
    protected $socketPrefix;
    protected $driver;
}