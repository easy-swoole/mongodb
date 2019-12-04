<?php
/**
 * Created by PhpStorm.
 * User: Manlin
 * Date: 2019/11/20
 * Time: 4:41 下午
 */
namespace EasySwoole\MongoDb\Protocol;

class Insert extends Protocol
{
    public function encode (array $payloads = []): string
    {
        // todo requestID, responseTo
        $header = $this->requestHeader(self::OP_INSERT, self::OP_INSERT,self::OP_INSERT);
        $data   = self::pack(self::BIT_B32, 0);// ZERO
        $data  .= self::pack(self::BIT_B32, (string) $payloads['fullCollectionName']);// fullCollectionName
        $data  .= self::pack(self::BIT_B32, $payloads['documents']);// documents
//        $data  .= bin2hex($payloads['documents']);
        $data   = self::encodeString($header . $data, self::PACK_INT32);
        return $data;
    }

    public function decode (string $data): array
    {
        // TODO: Implement decode() method.
    }
}
