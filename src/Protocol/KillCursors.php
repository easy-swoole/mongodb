<?php
/**
 * Created by PhpStorm.
 * User: Manlin
 * Date: 2019/11/20
 * Time: 4:58 下午
 */
namespace EasySwoole\MongoDb\Protocol;

class KillCursors extends Protocol
{
    public function encode (array $payloads = []): string
    {
        // todo requestID, responseTo
        $header = $this->requestHeader(self::OP_KILL_CURSORS, 1,self::OP_KILL_CURSORS);
        $data   = self::pack(self::BIT_B32, 0);// ZERO
        $data  .= self::pack(self::BIT_B32, $payloads['numberOfCursorIDs']);// numberOfCursorIDs
        $data  .= self::pack(self::BIT_B64, $payloads['cursorIDs']);// cursorIDs
        $data   = self::encodeString($header . $data, self::PACK_INT32);

        return $data;
    }

    public function decode (string $data): array
    {
        // TODO: Implement decode() method.
    }
}
