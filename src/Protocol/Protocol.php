<?php
/**
 * Created by PhpStorm.
 * User: Manlin
 * Date: 2019/11/20
 * Time: 8:55 上午
 */
namespace EasySwoole\MongoDb\Protocol;

use EasySwoole\MongoDb\Exception\ProtocolException;

abstract class Protocol
{
    public const DEFAULT_VERION = '0.9.0.0';

    /**
     *  pack int32 type
     */
    public const PACK_INT32 = 0;

    /**
     * pack int16 type
     */
    public const PACK_INT16 = 1;

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

    // unpack/pack bit
    public const BIT_B64 = 'N2';

    public const BIT_B32 = 'N';

    public const BIT_B16 = 'n';

    public const BIT_B16_SIGNED = 's';

    public const BIT_B8 = 'C';

    /**
     * @var string
     */
    protected $version = self::DEFAULT_VERION;

    private static $isLittleEndianSystem;

    /**
     * Protocol constructor.
     * @param string $version
     */
    public function __construct (string $version = self::DEFAULT_VERION)
    {
        $this->version = $version;
    }

    /**
     * Converts a signed short (16 bits) from little endian to big endian.
     *
     * @param int[] $bits
     *
     * @return int[]
     */
    public static function convertSignedShortFromLittleEndianToBigEndian (array $bits): array
    {
        $convert = function (int $bit): int {
            $lsb = $bit & 0xff;
            $msb = $bit >> 8 & 0xff;
            $bit = $lsb << 8 | $msb;

            if ($bit >= 32768) {
                $bit -= 65536;
            }

            return $bit;
        };

        return array_map($convert, $bits);
    }

    /**
     * @param int $requestID
     * @param int $responseTo
     * @param int $opCode
     * @return string
     */
    public function requestHeader (int $requestID, int $responseTo, int $opCode): string
    {
        $requestID      = self::pack(self::BIT_B32, $requestID);
        $responseTo     = self::pack(self::BIT_B32, $responseTo);
        $opCode         = self::pack(self::BIT_B32, $opCode);

        $binData = $requestID . $responseTo . $opCode;
        return $binData;
    }

    /**
     * @param string $type
     * @param string $bytes
     * @return array|false|int|int[]|mixed
     * @throws ProtocolException
     */
    public static function unpack (string $type, string $bytes)
    {
        self::checkLen($type, $bytes);

        if ($type === self::BIT_B64) {
            $set = unpack($type, $bytes);
            $result = ($set[1] & 0xFFFFFFFF) << 32 | ($set[2] & 0xFFFFFFFF);
        } elseif ($type === self::BIT_B16_SIGNED) {
            // According to PHP docs: 's' = signed short (always 16 bit, machine byte order)
            // So lets unpack it..
            $set = unpack($type, $bytes);

            // But if our system is little endian
            if (self::isSystemLittleEndian()) {
                $set = self::convertSignedShortFromLittleEndianToBigEndian($set);
            }
            $result = $set;
        } else {
            $result = unpack($type, $bytes);
        }

        return is_array($result) ? array_shift($result) : $result;
    }

    public static function pack (string $type, string $data): string
    {
        if ($type !== self::BIT_B64) {
            return pack($type, $data);
        }

        if ((int)$data === -1) { // -1L
            return hex2bin('ffffffffffffffff');
        }

        if ((int)$data === -2) { // -2L
            return hex2bin('fffffffffffffffe');
        }

        $left = 0xffffffff00000000;
        $right = 0x00000000ffffffff;

        $l = ($data & $left) >> 32;
        $r = $data & $right;

        return pack($type, $l, $r);
    }

    /**
     * @param string $type
     * @param string $bytes
     * @throws ProtocolException
     */
    protected static function checkLen (string $type, string $bytes): void
    {
        $expectedLength = 0;
        switch ($type) {
            case self::BIT_B64:
                $expectedLength = 8;
                break;
            case self::BIT_B32:
                $expectedLength = 4;
                break;
            case self::BIT_B16_SIGNED:
            case self::BIT_B16:
                $expectedLength = 2;
                break;
            case self::BIT_B8:
                $expectedLength = 1;
                break;
        }

        $length = strlen($bytes);

        if ($length !== $expectedLength) {
            throw new ProtocolException('unpack failed. string(raw) length is ' . $length . ' , TO ' . $type);
        }
    }

    /**
     * @param string $string
     * @param int    $bytes
     * @return string
     */
    public static function encodeString (string $string, int $bytes): string
    {
        $packLen = $bytes === self::PACK_INT32 ? self::BIT_B32 : self::BIT_B16;

        return self::pack($packLen, (string)strlen($string)) . $string;

        $allLen  = self::pack($packLen, (string)strlen($string)) . $string;
        return self::pack($packLen, (string)strlen($allLen)) . $allLen;
    }

    /**
     * @param array    $array
     * @param callable $func
     * @param int|null $options
     * @return string
     */
    public static function encodeArray (array $array, callable $func, ?int $options = null): string
    {
        $arrayCount = count($array);

        $body = '';
        foreach ($array as $value) {
            $body .= $options !== null ? $func($value, $options) : $func($value);
        }

        return self::pack(self::BIT_B32, (string)$arrayCount) . $body;
    }

    /**
     * @param string   $data
     * @param callable $func
     * @param null     $options
     * @return array
     * @throws ProtocolException
     */
    public function decodeArray (string $data, callable $func, $options = null): array
    {
        $offset = 0;
        $arrayCount = self::unpack(self::BIT_B32, substr($data, $offset, 4));
        $offset += 4;
        $result = [];

        for ($i = 0; $i < $arrayCount; $i++) {
            $value = substr($data, $offset);
            $ret = $options !== null ? $func($value, $options) : $func($value);

            if (!is_array($ret) && $ret === false) {
                break;
            }

            if (!isset($ret['length'], $ret['data'])) {
                throw new ProtocolException('Decode array failed, given function return format is invalid');
            }
            if ((int)$ret['length'] === 0) {
                continue;
            }

            $offset += $ret['length'];
            $result[] = $ret['data'];
        }
        return ['length' => $offset, 'data' => $result];
    }

    /**
     * @param string $data
     * @param string $bytes
     * @return array
     * @throws ProtocolException
     */
    public function decodeString (string $data, string $bytes): array
    {
        $offset = $bytes === self::BIT_B32 ? 4 : 2;
        $packLen = self::unpack($bytes, substr($data, 0, $offset)); // int16 topic name length

        if ($packLen === 4294967295) { // uint32(4294967295) is int32 (-1)
            $packLen = 0;
        }

        if ($packLen === 0) {
            return ['length' => $offset, 'data' => ''];
        }

        $data = (string)substr($data, $offset, $packLen);
        $offset += $packLen;

        return ['length' => $offset, 'data' => $data];
    }

    /**
     * @param string $data
     * @param string $bit
     * @return array
     * @throws ProtocolException
     */
    public function decodePrimitiveArray (string $data, string $bit): array
    {
        $offset = 0;
        $arrayCount = self::unpack(self::BIT_B32, substr($data, $offset, 4));
        $offset += 4;

        if ($arrayCount === 4294967295) {
            $arrayCount = 0;
        }

        $result = [];

        for ($i = 0; $i < $arrayCount; $i++) {
            if ($bit === self::BIT_B64) {
                $result[] = self::unpack(self::BIT_B64, substr($data, $offset, 8));
                $offset += 8;
            } elseif ($bit === self::BIT_B32) {
                $result[] = self::unpack(self::BIT_B32, substr($data, $offset, 4));
                $offset += 4;
            } elseif (in_array($bit, [self::BIT_B16, self::BIT_B16_SIGNED], true)) {
                $result[] = self::unpack($bit, substr($data, $offset, 2));
                $offset += 2;
            } elseif ($bit === self::BIT_B8) {
                $result[] = self::unpack($bit, substr($data, $offset, 1));
                ++$offset;
            }
        }

        return ['length' => $offset, 'data' => $result];
    }

    public static function isSystemLittleEndian (): bool
    {
        // If we don't know if our system is big endian or not yet...
        if (self::$isLittleEndianSystem === null) {
            [$endianTest] = array_values(unpack('L1L', pack('V', 1)));

            self::$isLittleEndianSystem = (int)$endianTest === 1;
        }

        return self::$isLittleEndianSystem;
    }

    /**
     * @param array $payloads
     * @return string
     */
    abstract public function encode (array $payloads = []): string;

    /**
     * @param string $data
     * @return array
     */
    abstract public function decode (string $data): array;
}
