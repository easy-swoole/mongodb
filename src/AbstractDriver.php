<?php


namespace EasySwoole\MongoDb;


use EasySwoole\Component\Process\Socket\AbstractUnixProcess;
use EasySwoole\Component\Process\Socket\UnixProcessConfig;
use Swoole\Coroutine\Channel;
use Swoole\Coroutine\Socket;

abstract class AbstractDriver extends AbstractUnixProcess
{
    function __construct(UnixProcessConfig $config)
    {
        //强制设置回调为有序执行
        $config->setAsyncCallback(false);
        parent::__construct($config);
    }

    private $isTransactionStart = false;
    private $client;
    function onAccept(Socket $socket)
    {
        //解析出命令
        $command =  $this->recv($socket);
        if($command->getAction() == 'startTransaction')
        {
            $this->isTransactionStart = $this->startTransaction();
            if($this->isTransactionStart){
                //回复成功消息，并进入阻塞等待命令
                //最多等待30s
                $channel = new Channel(1);
                go(function ()use($channel,$socket){
                    $channel->push($this->recv($socket,30));
                });
                $command = $channel->pop(30);
                if($command){
                    while (1){
                        //执行命令，直到rollback或者endTransaction退出循环
                        //在可以保证在开启事务的时候，只要客户端长连接,就可以保证事务
                        $command = $this->recv($socket);
                        //执行对应的action并回复
                    }
                    //断开连接
                }else{
                    //回复失败消息并断开
                    $this->isTransactionStart = $this->endTransaction();
                }
            }else{
                //回复失败消息并断开
            }
        }else{
            //执行对应的action并回复后断开
        }
    }


    abstract protected function createClient():? \MongoDB;
    abstract public function startTransaction():bool ;
    abstract public function endTransaction():bool ;
    abstract public function rollback():bool ;

    protected function getClient():?\MongoDB
    {
        if(!isset($this->client)){
            $this->client = $this->createClient();
        }
        return $this->client;
    }

    private function recv(Socket $socket,$timeout = 1):Command
    {

    }

}