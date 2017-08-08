<?php
namespace DbSystel\DataObject;

class FileParameter extends AbstractDataObject
{

    const BLOCKING_VARIABLE = 'vb';

    const BLOCKING_FIXED = 'fb';

    /**
     *
     * @var int
     */
    protected $id;

    /**
     *
     * @var string
     */
    protected $filename;

    /**
     *
     * @var int
     */
    protected $recordLength;

    /**
     *
     * @var string
     */
    protected $blocking;

    /**
     *
     * @var int
     */
    protected $blockSize;

    /**
     *
     * @var FileParameterSet
     */
    protected $fileParameterSet;

    /**
     *
     * @return int $id
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     *
     * @param number $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     *
     * @return string $filename
     */
    public function getFilename()
    {
        return $this->filename;
    }

    /**
     *
     * @param string $filename
     */
    public function setFilename($filename)
    {
        $this->filename = $filename;
    }

    /**
     *
     * @return int $recordLength
     */
    public function getRecordLength()
    {
        return $this->recordLength;
    }

    /**
     *
     * @param number $recordLength
     */
    public function setRecordLength($recordLength)
    {
        $this->recordLength = $recordLength;
    }

    /**
     *
     * @return string $blocking
     */
    public function getBlocking()
    {
        return $this->blocking;
    }

    /**
     *
     * @param string $blocking
     */
    public function setBlocking($blocking)
    {
        $this->blocking = $blocking;
    }

    /**
     *
     * @return int $blockSize
     */
    public function getBlockSize()
    {
        return $this->blockSize;
    }

    /**
     *
     * @param number $blockSize
     */
    public function setBlockSize($blockSize)
    {
        $this->blockSize = $blockSize;
    }

    /**
     *
     * @return FileParameterSet $fileParameterSet
     */
    public function getFileParameterSet()
    {
        return $this->fileParameterSet;
    }

    /**
     *
     * @param FileParameterSet $fileParameterSet
     */
    public function setFileParameterSet(FileParameterSet $fileParameterSet)
    {
        $this->fileParameterSet = $fileParameterSet;
    }

}
