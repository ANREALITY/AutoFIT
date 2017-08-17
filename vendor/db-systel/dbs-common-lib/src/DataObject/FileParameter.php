<?php
namespace DbSystel\DataObject;

class FileParameter extends AbstractDataObject
{

    const BLOCKING_VARIABLE = 'vb';

    const BLOCKING_FIXED = 'fb';

    /**
     *
     * @var integer
     */
    protected $id;

    /**
     *
     * @var string
     */
    protected $filename;

    /**
     *
     * @var integer
     */
    protected $recordLength;

    /**
     *
     * @var string
     */
    protected $blocking;

    /**
     *
     * @var integer
     */
    protected $blockSize;

    /**
     *
     * @var FileParameterSet
     */
    protected $fileParameterSet;

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
     * @return integer $id
     */
    public function getId()
    {
        return $this->id;
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
     * @return string $filename
     */
    public function getFilename()
    {
        return $this->filename;
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
     * @return integer $recordLength
     */
    public function getRecordLength()
    {
        return $this->recordLength;
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
     * @return string $blocking
     */
    public function getBlocking()
    {
        return $this->blocking;
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
     * @return integer $blockSize
     */
    public function getBlockSize()
    {
        return $this->blockSize;
    }

    /**
     *
     * @param FileParameterSet $fileParameterSet
     */
    public function setFileParameterSet(FileParameterSet $fileParameterSet)
    {
        $this->fileParameterSet = $fileParameterSet;
    }

    /**
     *
     * @return FileParameterSet $fileParameterSet
     */
    public function getFileParameterSet()
    {
        return $this->fileParameterSet;
    }

}
