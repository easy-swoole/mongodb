<?php


namespace EasySwoole\Phpunit;


use PHPUnit\TextUI\Command;
use Swoole\ExitException;
use Swoole\Timer;

class Runner
{
    public static function run()
    {
        try{
            Command::main(false);
        }catch (\Throwable $throwable){
            /*
             * 屏蔽swoole exit报错
             */
            if(!$throwable instanceof ExitException){
                throw $throwable;
            }
        }finally{
            Timer::clearAll();
        }
    }
}