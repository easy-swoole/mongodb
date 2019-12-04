<?php
/**
 * Created by PhpStorm.
 * User: Manlin
 * Date: 2019/11/20
 * Time: 4:55 下午
 */
namespace EasySwoole\MongoDb\Protocol;

class Delete extends Protocol
{
    public function encode (array $payloads = []): string
    {
        // todo requestID, responseTo
        $header = $this->requestHeader(self::OP_DELETE, 1,self::OP_DELETE);
        $data   = self::pack(self::BIT_B32, 0);// ZERO
        $data  .= self::pack(self::BIT_B32, (string) $payloads['fullCollectionName']);// fullCollectionName
        $data  .= self::pack(self::BIT_B32, $payloads['flags']);// flags
        $data  .= self::pack(self::BIT_B32, (string) $payloads['selector']);// selector
        $data   = self::encodeString($header . $data, self::PACK_INT32);

        return $data;
    }

    public function decode (string $data): array
    {
        // TODO: Implement decode() method.
    }

}