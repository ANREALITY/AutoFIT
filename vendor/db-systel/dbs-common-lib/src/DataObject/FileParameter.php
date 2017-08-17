<?php
namespace DbSystel\DataObject;

/**
 * FileParameter
 */
class FileParameter extends AbstractDataObject
{

    const BLOCKING_VARIABLE = 'vb';

    const BLOCKING_FIXED = 'fb';

    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $filename;

    /**
     * @var integer
     */
    private $recordLength;

    /**
     * @var string
     */
    private $blocking;

    /**
     * @var integer
     */
    private $blockSize;

    /**
     * @var FileParameterSet
     */
    private $fileParameterSet;

    /**
     * @param integer $id
     * @return FileParameter
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @return integer $id
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param string $filename
     * @return FileParameter
     */
    public function setFilename($filename)
    {
        $this->filename = $filename;

        return $this;
    }

    /**
     * @return string
     */
    public function getFilename()
    {
        return $this->filename;
    }

    /**
     * @param integer $recordLength
     * @return FileParameter
     */
    public function setRecordLength($recordLength)
    {
        $this->recordLength = $recordLength;

        return $this;
    }

    /**
     * @return integer $recordLength
     */
    public function getRecordLength()
    {
        return $this->recordLength;
    }

    /**
     * @param string $blocking
     * @return FileParameter
     */
    public function setBlocking($blocking)
    {
        $this->blocking = $blocking;

        return $this;
    }

    /**
     * @return string
     */
    public function getBlocking()
    {
        return $this->blocking;
    }

    /**
     * @param integer $blockSize
     * @return FileParameter
     */
    public function setBlockSize($blockSize)
    {
        $this->blockSize = $blockSize;

        return $this;
    }

    /**
     * @return integer $blockSize
     */
    public function getBlockSize()
    {
        return $this->blockSize;
    }

    /**
     * @param FileParameterSet $fileParameterSet
     * @return FileParameter
     */
    public function setFileParameterSet(FileParameterSet $fileParameterSet)
    {
        $this->fileParameterSet = $fileParameterSet;

        return $this;
    }

    /**
     * @return FileParameterSet $fileParameterSet
     */
    public function getFileParameterSet()
    {
        return $this->fileParameterSet;
    }

}
