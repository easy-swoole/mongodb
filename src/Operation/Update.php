<?php
/**
 * Created by PhpStorm.
 * User: Manlin
 * Date: 2020/1/3
 * Time: 11:08 上午
 */
namespace EasySwoole\MongoDb\Operation;

use EasySwoole\MongoDb\Exception\ConnectionException;
use EasySwoole\MongoDb\Params\Update as ParamsUpdate;
use EasySwoole\MongoDb\Protocol;
use function MongoDB\BSON\fromPHP;

class Update extends BaseOperation
{
    public function execute(ParamsUpdate $update)
    {
        $hostname = $this->getConfig()->getHostname();
        $connect  = $this->getBroker()->getConnect($hostname);

        if ($connect === null) {
            throw new ConnectionException();
        }

        $params = [
            'flags'                 => $update->getFlags(),
            'fullCollectionName'    => $update->getFullCollectionName(),
            'selector'              => $update->getSelector(),
            'update'                => $update->getUpdate()
        ];

        try {
            $requestData = Protocol::encode(Protocol::OP_UPDATE, $params);
            var_dump($requestData);
            $data = $connect->send($requestData);
            var_dump($data);
        } catch (\Exception $e) {
            var_dump($e->getMessage());
        }
    }
}
