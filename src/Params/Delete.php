<?php
/**
 * Created by PhpStorm.
 * User: Manlin
 * Date: 2020/1/3
 * Time: 1:15 下午
 */
namespace EasySwoole\MongoDb\Params;

class Delete extends BaseParams
{
    /**
     * @var int bit vector
     */
    private $flags = 0;

    /**
     * BSON document that specifies the query for selection of the document to update.
     * @var
     */
    private $selector;

    /**
     * @return int
     */
    public function getFlags (): int
    {
        return $this->flags;
    }

    /**
     * @param int $flags
     */
    public function setFlags (int $flags): void
    {
        $this->flags = $flags;
    }

    /**
     * @return mixed
     */
    public function getSelector ()
    {
        return $this->selector;
    }

    /**
     * @param mixed $selector
     */
    public function setSelector ($selector): void
    {
        $this->selector = $selector;
    }
}
