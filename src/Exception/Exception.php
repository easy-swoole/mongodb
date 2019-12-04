<?php
/**
 * Created by PhpStorm.
 * User: Manlin
 * Date: 2019/11/18
 * Time: 2:14 下午
 */
namespace EasySwoole\MongoDb\Exception;

use MongoDB\Driver\Exception\Exception as DriverException;

interface Exception extends DriverException
{
}
