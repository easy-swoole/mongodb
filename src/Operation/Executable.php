<?php
/**
 * Created by PhpStorm.
 * User: Manlin
 * Date: 2019/11/18
 * Time: 2:44 下午
 */
namespace EasySwoole\MongoDb\Operation;

use EasySwoole\MongoDb\Params\BaseParams;

interface Executable
{
    /**
     * Execute the operation.
     * @param BaseParams $service
     * @return mixed
     */
    public function execute(BaseParams $service);
}
