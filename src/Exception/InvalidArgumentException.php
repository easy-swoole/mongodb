<?php
/**
 * Created by PhpStorm.
 * User: Manlin
 * Date: 2019/11/18
 * Time: 2:09 下午
 */
namespace EasySwoole\MongoDb\Exception;

use MongoDB\Driver\Exception\InvalidArgumentException as DriverInvalidArgumentException;

class InvalidArgumentException extends DriverInvalidArgumentException implements Exception
{
    /**
     * * Thrown when an argument or option has an invalid type.
     *
     * @param string $name         Name of the argument or option
     * @param mixed  $value        Actual value (used to derive the type)
     * @param string $expectedType Expected type
     * @return static
     */
    public static function invalidType($name, $value, $expectedType)
    {
        return new static(sprintf('Expected %s to have type "%s" but found "%s"', $name, $expectedType, is_object($value) ? get_class($value) : gettype($value)));
    }
}
