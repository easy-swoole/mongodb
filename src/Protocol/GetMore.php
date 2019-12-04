<?php
/**
 * Created by PhpStorm.
 * User: Manlin
 * Date: 2019/11/20
 * Time: 4:51 下午
 */
namespace EasySwoole\MongoDb\Protocol;

class GetMore extends Protocol
{
    public function encode (array $payloads = []): string
    {
        // todo requestID, responseTo
        $header = $this->requestHeader(self::OP_GET_MORE, 1,self::OP_GET_MORE);
        $data   = self::pack(self::BIT_B32, 0);// ZERO
        $data  .= self::pack(self::BIT_B32, (string) $payloads['fullCollectionName']);// fullCollectionName
        $data  .= self::pack(self::BIT_B32, $payloads['numberToReturn']);// numberToReturn
        $data  .= self::pack(self::BIT_B64, $payloads['cursorID']);// cursorID
        $data   = self::encodeString($header . $data, self::PACK_INT32);

        return $data;
    }

    public function decode (string $data): array
    {
        // TODO: Implement decode() method.
    }
}
