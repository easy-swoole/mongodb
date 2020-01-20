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

    /**
     * @param string $data
     * @return array
     * @throws ProtocolException
     */
    public function decode (string $data): array
    {
        $offset        = 0;
        $requestID      = self::pack(self::BIT_B32, substr($data, $offset, 4));
        $offset       += 4;
        $responseTo     = self::pack(self::BIT_B32, substr($data, $offset, 4));
        $offset       += 4;
        $opCode         = self::pack(self::BIT_B32, substr($data, $offset, 4));
        $offset       += 4;
        $responseFlags = self::unpack(self::BIT_B32, substr($data, $offset, 4));
        $offset       += 4;
        $generationId  = self::unpack(self::BIT_B32, substr($data, $offset, 4));
        $offset       += 4;
        $cursorID      = self::unpack(self::BIT_B64, substr($data, $offset, 8));
        $offset       += 8;
        $startingFrom  = self::unpack(self::BIT_B64, substr($data, $offset, 4));
        $offset       += 4;
        $numberReturned= self::unpack(self::BIT_B64, substr($data, $offset, 4));
        $offset       += 4;
        $documents     = $this->decodeString(substr($data, $offset), self::BIT_B32);
        $offset       += $documents['length'];

        return [
            'requestID'     => $requestID,
            'responseTo'    => $responseTo,
            'opCode'        => $opCode,
            'responseFlags' => $responseFlags,
            'generationId'  => $generationId,
            'cursorID'      => $cursorID,
            'startingFrom'  => $startingFrom,
            'numberReturned'=> $numberReturned,
            'documents'     => $documents['data'],
        ];
    }
}
