<?php
namespace DbSystel\DataObject;

class FileParameter extends AbstractDataObject
{

    const BLOCKING_TYPE_VARIABLE = 'vb';

    const BLOCKING_TYPE_FIXED = 'fb';

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
    protected $record_size;

    /**
     *
     * @var string
     */
    protected $bocking_tyle;

    /**
     *
     * @var int
     */
    protected $block_size;

    /**
     *
     * @var FileParameterSet
     */
    protected $fileParameterSet;

    /**
     *
     * @return the $id
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
     * @return the $filename
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
     * @return the $record_size
     */
    public function getRecord_size()
    {
        return $this->record_size;
    }

    /**
     *
     * @param number $record_size
     */
    public function setRecord_size($record_size)
    {
        $this->record_size = $record_size;
    }

    /**
     *
     * @return the $bocking_tyle
     */
    public function getBocking_tyle()
    {
        return $this->bocking_tyle;
    }

    /**
     *
     * @param string $bocking_tyle
     */
    public function setBocking_tyle($bocking_tyle)
    {
        $this->bocking_tyle = $bocking_tyle;
    }

    /**
     *
     * @return the $block_size
     */
    public function getBlock_size()
    {
        return $this->block_size;
    }

    /**
     *
     * @param number $block_size
     */
    public function setBlock_size($block_size)
    {
        $this->block_size = $block_size;
    }

    /**
     *
     * @return the $fileParameterSet
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
