<?php
/**
 * Created by PhpStorm.
 * User: Manlin
 * Date: 2019/11/22
 * Time: 5:26 下午
 */
namespace EasySwoole\MongoDb\Operation;

use EasySwoole\MongoDb\Exception\ConnectionException;
use EasySwoole\MongoDb\Protocol;
use Exception;
use EasySwoole\MongoDb\Params\Insert as ParamsInsert;
use function MongoDB\BSON\fromPHP;

class Insert extends BaseOperation
{
    /**
     * @param ParamsInsert $insert
     * @throws Exception
     */
    public function execute (ParamsInsert $insert)
    {
        $hostname = $this->getConfig()->getHostname();
        $connect  = $this->getBroker()->getConnect($hostname);

        if ($connect === null) {
            throw new ConnectionException();
        }

        $params = [
            'flags'                 => $insert->getFlags(),
            'fullCollectionName'    => $insert->getFullCollectionName(),
            'documents'             => bin2hex(fromPHP($insert->getDocuments()))
        ];

        var_dump($params);
        $requestData = Protocol::encode(Protocol::OP_INSERT, $params);
        $data = $connect->send($requestData);
        var_dump($data);
//        $ret  = Protocol::decode(Protocol::OP_INSERT, substr($data, 4));
//        return $ret;
    }
}
