<?php

require_once 'vendor/autoload.php';
//$rawQuery = '';

//$client = new \MongoDB\Client('mongodb://192.168.3.30:27017/?journal=true&w=majority&wTimeoutMS=20000');
//$collection = (new MongoDB\Client)->test->users;
//
//$insertOneResult = $collection->insertOne([
//    'username' => 'admin'
//]);
//
//printf("Inserted %d document(s)\n", $insertOneResult->getInsertedCount());
//
//var_dump($insertOneResult->getInsertedId());
//
//die();


function hexToStr($hex){
    $str="";
    for($i=0;$i<strlen($hex)-1;$i+=2)
        $str.=chr(hexdec($hex[$i].$hex[$i+1]));
    return $str;
}

//a.txt为以上同步版本的第一个握手数据包，wireshake看到的数据为430长度，strlen得到的为860。把str pack到430长度发送应该就可以得到响应

go(function (){
    $client = new \Swoole\Coroutine\Client(SWOOLE_TCP);
    var_dump($client->connect('127.0.0.1',27017));
    $str = '';
    $file = file('a.txt');
    foreach ($file as $line){
        $str =  $str.trim($line,"\"\n");
    }
    $str = hexToStr($str);
    var_dump(strlen($str));
    $client->send($str);
    var_dump($client->recv());
});