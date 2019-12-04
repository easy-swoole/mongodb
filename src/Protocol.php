<?php
namespace EasySwoole\MongoDb;

use Exception;

class Protocol
{
    /**
     * protocol request code
     */
    public const OP_REPLY = 1;
    public const OP_UPDATE = 2001;
    public const OP_INSERT = 2002;
    public const RESERVED = 2003;
    public const OP_QUERY = 2004;
    public const OP_GET_MORE = 2005;
    public const OP_DELETE = 2006;
    public const OP_KILL_CURSORS = 2007;
    public const OP_MSG = 2013;

    /**
     * @var Protocol\Protocol[]
     */
    protected static $objects = [];

    public static function init(string $version): void
    {
        $class = [
            Protocol\Protocol::OP_REPLY         => Protocol\Reply::class,
            Protocol\Protocol::OP_UPDATE        => Protocol\Update::class,
            Protocol\Protocol::OP_INSERT        => Protocol\Insert::class,
            Protocol\Protocol::OP_QUERY         => Protocol\Query::class,
            Protocol\Protocol::OP_GET_MORE      => Protocol\GetMore::class,
            Protocol\Protocol::OP_DELETE        => Protocol\Delete::class,
            Protocol\Protocol::OP_KILL_CURSORS  => Protocol\KillCursors::class,
            Protocol\Protocol::OP_MSG           => Protocol\Msg::class,
        ];

        foreach ($class as $key => $className) {
            self::$objects[$key] = new $className($version);
        }
    }

    /**
     * @param int   $key
     * @param array $payloads
     * @return string
     * @throws Exception
     */
    public static function encode(int $key, array $payloads): string
    {
        if (! isset(self::$objects[$key])) {
            throw new Exception("Not support api key, key:" . $key);
        }

        return self::$objects[$key]->encode($payloads);
    }

    /**
     * @param int    $key
     * @param string $data
     * @return array
     * @throws Exception
     */
    public static function decode(int $key, string $data): array
    {
        if (! isset(self::$objects[$key])) {
            throw new Exception("Not support api key, key:" . $key);
        }

        return self::$objects[$key]->decode($data);
    }
}
