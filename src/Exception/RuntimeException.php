<?php
/**
 * Created by PhpStorm.
 * User: Manlin
 * Date: 2019/11/18
 * Time: 2:28 下午
 */
namespace EasySwoole\MongoDb\Exception;

use MongoDB\Driver\Exception\RuntimeException as DriverRuntimeException;

class RuntimeException extends DriverRuntimeException implements Exception
{
}
