<?php
namespace EasySwoole\MongoDb;

use EasySwoole\MongoDb\Exception;

class Broker
{
    private $client;

    /**
     * @param string $hostname
     * @return Client|null
     */
    public function getConnect(string $hostname): ?Client
    {
        // 如果之前连接了，返回之前的连接
        if ($this->client) {
            return  $this->client;
        }
        $host = null;
        $port = null;

        [$host, $port] = explode(':', $hostname);

        if ($host === null || $port === null) {
            return null;
        }
        try {
            $client = $this->getClient((string)$host, (int)$port);
            if ($client->connect()) {
                $this->client = $client;
                return $client;
            }
        } catch (\Throwable $exception) {
            throw new Exception\ConnectionException($exception);
        }
        return null;
    }

    /**
     * @param string $host
     * @param int    $port
     * @return Client|null
     */
    private function getClient(string $host, int $port): ?Client
    {
        return new Client($host, $port);
    }
}
