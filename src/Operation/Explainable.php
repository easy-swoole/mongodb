<?php
/**
 * Created by PhpStorm.
 * User: Manlin
 * Date: 2019/11/18
 * Time: 2:45 下午
 */
namespace EasySwoole\MongoDb\Operation;

use MongoDB\Driver\Server;

interface Explainable extends Executable
{
    public function getCommandDocument(Server $server);
}
