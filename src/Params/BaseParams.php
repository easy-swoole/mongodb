<?php
/**
 * Created by PhpStorm.
 * User: Manlin
 * Date: 2019/11/23
 * Time: 8:45 上午
 */
namespace EasySwoole\MongoDb\Params;

use EasySwoole\Spl\SplBean;

class BaseParams extends SplBean
{
    /**
     * @var string "dbname.collectionname"
     */
    private $fullCollectionName;

    /**
     * @return string
     */
    public function getFullCollectionName (): string
    {
        return $this->fullCollectionName;
    }

    /**
     * @param string $fullCollectionName
     */
    public function setFullCollectionName (string $fullCollectionName): void
    {
        $this->fullCollectionName = $fullCollectionName;
    }
}
