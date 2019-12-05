<?php
/**
 * Created by PhpStorm.
 * User: Manlin
 * Date: 2019/12/3
 * Time: 2:14 下午
 */
namespace EasySwoole\MongoDb\Test;

use EasySwoole\MongoDb\Config;
use EasySwoole\MongoDb\Exception\ConfigException;
use EasySwoole\MongoDb\MongoDb;
use EasySwoole\MongoDb\Params\Query;
use PHPUnit\Framework\TestCase;

class QueryTest extends TestCase
{
    /**
     * @throws ConfigException
     */
    public function testQuery()
    {
        $config = new Config();
        $config->setHostname('116.62.51.202:27017');

        $queryData = new Query();
//        $queryData->setFlags(0);
        $queryData->setFullCollectionName('test.sites');
//        $queryData->setNumberToSkip(0);
        $queryData->setNumberToReturn(1);
        $queryData->setQuery(['x' => ['$gt' => 1]]);
//        $queryData->setReturnFieldsSelector([]);

        $mongo = new MongoDb($config);
        $mongo->query($queryData);
    }
}
