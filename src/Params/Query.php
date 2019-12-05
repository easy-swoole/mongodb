<?php
/**
 * Created by PhpStorm.
 * User: Manlin
 * Date: 2019/12/3
 * Time: 1:59 下午
 */
namespace EasySwoole\MongoDb\Params;

/**
 * Class Query
 * @package EasySwoole\MongoDb\Params
 */
class Query extends BaseParams
{
    /**
     * @var int bit vector of query options.
     */
    private $flags = 0;

    /**
     * @var int number of documents to skip
     */
    private $numberToSkip = 0;

    /**
     * @var int number of documents to return
     */
    private $numberToReturn;

    /**
     * @var array query object.  See below for details.
     */
    private $query;

    /**
     * @var array Optional. Selector indicating the fields to return.  See below for details.
     */
    private $returnFieldsSelector = [];

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
     * @return int
     */
    public function getNumberToSkip (): int
    {
        return $this->numberToSkip;
    }

    /**
     * @param int $numberToSkip
     */
    public function setNumberToSkip (int $numberToSkip): void
    {
        $this->numberToSkip = $numberToSkip;
    }

    /**
     * @return int
     */
    public function getNumberToReturn (): int
    {
        return $this->numberToReturn;
    }

    /**
     * @param int $numberToReturn
     */
    public function setNumberToReturn (int $numberToReturn): void
    {
        $this->numberToReturn = $numberToReturn;
    }

    /**
     * @return array
     */
    public function getQuery (): array
    {
        return $this->query;
    }

    /**
     * @param array $query
     */
    public function setQuery (array $query): void
    {
        $this->query = $query;
    }

    /**
     * @return array
     */
    public function getReturnFieldsSelector (): array
    {
        return $this->returnFieldsSelector;
    }

    /**
     * @param array $returnFieldsSelector
     */
    public function setReturnFieldsSelector (array $returnFieldsSelector): void
    {
        $this->returnFieldsSelector = $returnFieldsSelector;
    }
}
