<?php
/**
 * Created by PhpStorm.
 * User: Manlin
 * Date: 2019/11/20
 * Time: 4:45 下午
 */
namespace EasySwoole\MongoDb\Protocol;

class Query extends Protocol
{
    public function encode (array $payloads = []): string
    {
        // todo requestID, responseTo
        $header = $this->requestHeader(self::OP_QUERY, 1,self::OP_QUERY);
        $data   = self::pack(self::BIT_B32, $payloads['flags']);// flags
        $data  .= self::pack(self::BIT_B32, (string) $payloads['fullCollectionName']);// fullCollectionName
        $data  .= self::pack(self::BIT_B32, $payloads['numberToSkip']);// numberToSkip
        $data  .= self::pack(self::BIT_B32, $payloads['numberToReturn']);// numberToReturn
        $data  .= self::pack(self::BIT_B32, (string) $payloads['query']);// query
        if (isset($payloads['returnFieldSelector'])) {
            $data .= self::pack(self::BIT_B32, (string) $payloads['returnFieldSelector']);// returnFieldSelector
        }
        $data   = self::encodeString($header . $data, self::PACK_INT32);

        return $data;
    }

    public function decode (string $data): array
    {
        // TODO: Implement decode() method.
    }
}
