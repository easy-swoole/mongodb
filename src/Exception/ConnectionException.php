<?php
/**
 * Created by PhpStorm.
 * User: Manlin
 * Date: 2019/11/22
 * Time: 2:51 下午
 */
namespace EasySwoole\MongoDb\Exception;

use MongoDB\Driver\Exception\ConnectionException as DriverConnectionException;

class ConnectionException extends DriverConnectionException implements Exception
{
}
