<?php
namespace EasySwoole\MongoDb;

use EasySwoole\MongoDb\Operation\Delete;
use EasySwoole\MongoDb\Operation\Insert;
use EasySwoole\MongoDb\Operation\Query;
use EasySwoole\MongoDb\Operation\Update;
use EasySwoole\MongoDb\Params\Insert as ParamsInsert;
use EasySwoole\MongoDb\Params\Query as ParamsQuery;
use EasySwoole\MongoDb\Params\Update as ParamsUpdate;
use EasySwoole\MongoDb\Params\Delete as ParamsDelete;
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

    public function update(ParamsUpdate $update)
    {
        $process = new Update($this->config);
        return $process->execute($update);
    }

    public function delete(ParamsDelete $delete)
    {
        $process = new Delete($this->config);
        return $process->execute($delete);
    }
}
