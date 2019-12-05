<?php
/**
 * Created by PhpStorm.
 * User: Manlin
 * Date: 2019/11/18
 * Time: 2:17 下午
 */
namespace EasySwoole\MongoDb\Exception;

use MongoDB\Driver\Exception\UnexpectedValueException as DriverUnexpectedValueException;

class UnexpectedValueException extends DriverUnexpectedValueException implements Exception
{
}
