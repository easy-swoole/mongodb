<?php
/**
 * Created by PhpStorm.
 * User: Manlin
 * Date: 2019/12/3
 * Time: 1:58 下午
 */
namespace EasySwoole\MongoDb\Operation;

use EasySwoole\MongoDb\Exception\ConnectionException;
use EasySwoole\MongoDb\Exception\RuntimeException;
use EasySwoole\MongoDb\Params\Query as ParamsQuery;
use EasySwoole\MongoDb\Protocol;
use function MongoDB\BSON\fromPHP;

class Query extends BaseOperation
{
    public function execute(ParamsQuery $query)
    {
        $hostname = $this->getConfig()->getHostname();
        $connect  = $this->getBroker()->getConnect($hostname);

        if ($connect === null) {
            throw new ConnectionException();
        }

        $params = [
            'flags'                 => $query->getFlags(),
            'fullCollectionName'    => $query->getFullCollectionName(),
            'numberToSkip'          => $query->getNumberToSkip(),
            'numberToReturn'        => $query->getNumberToReturn(),
            'query'                 => fromPHP($query->getQuery()),
            'returnFieldsSelector'  => fromPHP($query->getReturnFieldsSelector())
        ];

        try {
            $requestData = Protocol::encode(Protocol::OP_QUERY, $params);
            var_dump($requestData);
            $data = $connect->send($requestData);
            $ret  = Protocol::decode(Protocol::OP_REPLY, substr($data, 4));
            var_dump($ret);
        } catch (\Exception $e) {
            throw new RuntimeException($e->getMessage());
        }
    }
}
