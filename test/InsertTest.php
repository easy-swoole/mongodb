<?php
/**
 * Created by PhpStorm.
 * User: Manlin
 * Date: 2019/11/23
 * Time: 10:02 上午
 */
namespace EasySwoole\MongoDb\Test;

use EasySwoole\MongoDb\Config;
use EasySwoole\MongoDb\Exception\ConfigException;
use EasySwoole\MongoDb\MongoDb;
use EasySwoole\MongoDb\Params\Insert;
use Exception;
use MongoDB\BSON\ObjectId;
use MongoDB\Driver\BulkWrite;
use MongoDB\Driver\Manager;
use MongoDB\Driver\Query;
use PHPUnit\Framework\TestCase;
use function MongoDB\BSON\fromPHP;
use function MongoDB\BSON\toPHP;

class InsertTest extends TestCase
{
    public function __construct ($name = null, array $data = [], $dataName = '')
    {
        parent::__construct($name, $data, $dataName);
    }

    /**
     * @throws ConfigException
     * @throws Exception
     */
    public function testInsert()
    {
        $config = new Config();
        $config->setHostname('127.0.0.1:27017');

        $insertData = new Insert();
        $insertData->setFlags(0);
        $insertData->setFullCollectionName('test.test');
        $insertData->setDocuments(['foo' => 1]);

        $mongo = new MongoDb($config);
        $mongo->insert($insertData);
    }

//    public function testMongotest()
//    {
//        $aa = fromPHP(['a' => 1, 'b' => 2]);
//        var_dump(toPHP($aa));
//
//        $bb = bin2hex($aa);
//        var_dump($bb);
//
//        $bson = hex2bin($bb);
//        var_dump($bson);
//        $cc = toPHP($bson);
//        var_dump($cc);
//        var_dump($cc->a);
//
//        $mongo = new \MongoDB\Driver\Manager("mongodb://116.62.51.202:27017");
//    }

//    public function testMongotest2()
//    {
//        $manager = new Manager("mongodb://116.62.51.202:27017");
//
//        $filter = ['x' => ['$gt' => 1]];
//        $options = [
//            'projection' => ['_id' => 0],
//            'sort' => ['x' => -1],
//        ];
//
//        // 查询数据
//        $query = new Query($filter, $options);
//        $cursor = $manager->executeQuery('test.sites', $query);
//
//        foreach ($cursor as $document) {
//            print_r($document);
//        }
//    }

//    public function testMongoInser()
//    {
//        $bulk = new BulkWrite;
//
//        $document1 = ['title' => 'one'];
//
//        $_id1 = $bulk->insert($document1);
//        var_dump($_id1);
//        $manager = new Manager('mongodb://localhost:27017');
//        $result = $manager->executeBulkWrite('test.test', $bulk);
//        var_dump($result);
//    }
}
