<?php
namespace EasySwoole\MongoDb;

use EasySwoole\MongoDb\Operation\Insert;
use EasySwoole\MongoDb\Operation\Query;
use EasySwoole\MongoDb\Params\Insert as ParamsInsert;
use EasySwoole\MongoDb\Params\Query as ParamsQuery;
use Exception;

class MongoDb
{
    private $config;

    public function __construct(Config $config)
    {
        $this->config = $config;
    }

    /**
     * @param ParamsInsert $insert
     * @return array
     * @throws Exception
     */
    public function insert(ParamsInsert $insert)
    {
        $process = new Insert($this->config);
        return $process->execute($insert);
    }

    public function query(ParamsQuery $query)
    {
        $process = new Query($this->config);
        return $process->execute($query);
    }
}
