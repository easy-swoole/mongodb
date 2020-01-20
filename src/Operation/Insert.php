<?php
/**
 * Created by PhpStorm.
 * User: Manlin
 * Date: 2019/11/22
 * Time: 5:26 下午
 */
namespace EasySwoole\MongoDb\Operation;

use EasySwoole\MongoDb\Exception\ConnectionException;
use EasySwoole\MongoDb\Exception\RuntimeException;
use EasySwoole\MongoDb\Protocol;
use Exception;
use EasySwoole\MongoDb\Params\Insert as ParamsInsert;
use function MongoDB\BSON\fromPHP;

class Insert extends BaseOperation
{
    /**
     * @param ParamsInsert $insert
     * @return mixed
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
            'fullCollectionName'    => bin2hex($insert->getFullCollectionName()),
            'documents'             => bin2hex(fromPHP($insert->getDocuments()))
        ];

        var_dump($insert->getDocuments());
        var_dump(fromPHP($insert->getDocuments()));
        var_dump(bin2hex(fromPHP($insert->getDocuments())));

        var_dump($params);
        try {
            $requestData = Protocol::encode(Protocol::OP_INSERT, $params);
            $data = $connect->send($requestData);
            var_dump($data);
            return $data;
        } catch (Exception $exception) {
            throw new RuntimeException($exception->getMessage());
        }
    }
}
