<?php
/**
 * Created by PhpStorm.
 * User: Manlin
 * Date: 2020/1/3
 * Time: 11:09 上午
 */
namespace EasySwoole\MongoDb\Params;

class Update extends BaseParams
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
     * BSON document that specifies the update to be performed. For information on specifying updates see the
     * Update Operations documentation from the MongoDB Manual.
     * @see https://docs.mongodb.com/manual/tutorial/update-documents/
     * @var
     */
    private $update;

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
    public function getDocuments (): array
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

    /**
     * @return mixed
     */
    public function getUpdate ()
    {
        return $this->update;
    }

    /**
     * @param mixed $update
     */
    public function setUpdate ($update): void
    {
        $this->update = $update;
    }
}
