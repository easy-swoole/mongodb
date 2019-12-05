<?php
/**
 * Created by PhpStorm.
 * User: Manlin
 * Date: 2019/11/20
 * Time: 10:45 上午
 */
namespace EasySwoole\MongoDb\Protocol;

use EasySwoole\MongoDb\Exception\ProtocolException;

class Reply extends Protocol
{
    /**
     * @param array $payloads
     * @return string
     * @throws ProtocolException
     */
    public function encode (array $payloads = []): string
    {
        if (! isset($payloads['data'])) {
            throw new ProtocolException('given fetch kafka data invalid. `data` is undefined.');
        }

        if (! isset($payloads['replica_id'])) {
            $payloads['replica_id'] = -1;
        }

        if (! isset($payloads['max_wait_time'])) {
            $payloads['max_wait_time'] = 100; // default timeout 100ms
        }

        if (! isset($payloads['min_bytes'])) {
            $payloads['min_bytes'] = 64 * 1024; // 64k
        }

        $header = $this->requestHeader(self::OP_REPLY, 1,self::OP_REPLY);
        $data   = self::pack(self::BIT_B32, (string) $payloads['replica_id']);
        $data  .= self::pack(self::BIT_B32, (string) $payloads['max_wait_time']);
        $data  .= self::pack(self::BIT_B32, (string) $payloads['min_bytes']);
        $data  .= self::encodeArray((array) $payloads['data'], [$this, 'encodeFetchTopic']);
        $data   = self::encodeString($header . $data, self::PACK_INT32);

        return $data;
    }

    public function decode (string $data): array
    {
        // TODO: Implement decode() method.
    }
}
