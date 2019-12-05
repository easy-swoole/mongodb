<?php
/**
 * Created by PhpStorm.
 * User: Manlin
 * Date: 2019/11/22
 * Time: 6:01 下午
 */
namespace EasySwoole\MongoDb\Params;

class Insert extends BaseParams
{
    /**
     * @var int bit vector - see below
     */
    private $flags = 0;

    /**
     * @var array one or more documents to insert into the collection
     */
    private $documents;

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
     * @return array
     */
    public function getDocuments ()
    {
        return $this->documents;
    }

    /**
     * @param array $documents
     */
    public function setDocuments (array $documents): void
    {
        $this->documents = $documents;
    }
}
