<?php
namespace EasySwoole\MongoDb;

use EasySwoole\MongoDb\Exception\ConnectionException;
use EasySwoole\MongoDb\Exception\InvalidArgumentException;
use Swoole\Coroutine\Client as CoroutineClient;
use swoole_client;

class Client
{
    /*
     * @var string
     */
    protected $host;

    /**
     * @var int
     */
    protected $port = -1;

    /**
     * @var swoole_client
     */
    protected $client;

    /**
     * Client constructor.
     * @param string $host
     * @param int    $port
     */
    public function __construct(string $host, int $port)
    {
        $this->host = $host;
        $this->port = $port;
    }

    /**
     * @return bool
     */
    public function connect(): bool
    {
        if (trim($this->host) === '') {
            throw new InvalidArgumentException("Cannot open null host.");
        }

        if ($this->port <= 0) {
            throw new InvalidArgumentException("Cannot open without port.");
        }

        $settings = [
            'open_length_check'     => 1,
            'package_length_type'   => 'N',
            'package_length_offset' => 0,
            'package_body_offset'   => 4,
            'package_max_length'    => 1024 * 1024 * 3,
        ];

        if (!$this->client instanceof Client) {
            $this->client = new CoroutineClient(SWOOLE_TCP);
            $this->client->set($settings);
        }

        if (!$this->client->isConnected()) {
            $connected = $this->client->connect($this->host, $this->port);
            if (!$connected) {
                $connectStr = "tcp://{$this->host}:{$this->port}";
                throw new ConnectionException("Connect to Mongo server {$connectStr} failed: {$this->client->errMsg}");
            }
        }

        return (bool)$this->client->isConnected();
    }

    /**
     * @return bool
     */
    public function isConnected(): bool
    {
        if ($this->client->isConnected()) {
            return true;
        }

        return false;
    }

    /**
     * @param string|null $data
     * @return mixed
     */
    public function send(?string $data = null)
    {
        if ($this->connect()) {
            $this->client->send($data);
            return $this->client->recv();
        }
        $connectStr = "tcp://{$this->host}:{$this->port}";
        throw new ConnectionException("Connect to Mongo server {$connectStr} failed: {$this->client->errMsg}");
    }

    /**
     * @param float $timeout
     * @return string
     */
    public function recv(float $timeout = -1): string
    {
        if ($this->connect()) {
            $data = $this->client->recv($timeout);
            return $data;
        }
        $connectStr = "tcp://{$this->host}:{$this->port}";
        throw new ConnectionException("Connect to Mongo server {$connectStr} failed: {$this->client->errMsg}");
    }

    public function close()
    {
        $this->client->close();
    }
}
