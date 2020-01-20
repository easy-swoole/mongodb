<?php
/**
 * Created by PhpStorm.
 * User: Manlin
 * Date: 2020/1/3
 * Time: 1:15 下午
 */
namespace EasySwoole\MongoDb\Operation;

use EasySwoole\MongoDb\Exception\ConnectionException;
use EasySwoole\MongoDb\Params\Delete as ParamsDelete;
use EasySwoole\MongoDb\Protocol;

class Delete extends BaseOperation
{
    public function execute(ParamsDelete $delete)
    {
        $hostname = $this->getConfig()->getHostname();
        $connect  = $this->getBroker()->getConnect($hostname);

        if ($connect === null) {
            throw new ConnectionException();
        }

        $params = [
            'flags'                 => $delete->getFlags(),
            'fullCollectionName'    => $delete->getFullCollectionName(),
            'selector'              => $delete->getSelector(),
        ];

        try {
            $requestData = Protocol::encode(Protocol::OP_DELETE, $params);
            var_dump($requestData);
            $data = $connect->send($requestData);
            var_dump($data);
        } catch (\Exception $e) {
            var_dump($e->getMessage());
        }
    }
}
