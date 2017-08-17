<?php
namespace DbSystel\DataObject;

class FileParameterSet extends AbstractDataObject
{

    /**
     *
     * @var integer
     */
    protected $id;

    /**
     *
     * @var AbstractEndpoint
     */
    protected $endpoint;

    /**
     *
     * @var FileParameter[]
     */
    protected $fileParameters;

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
     * @param AbstractEndpoint $endpoint
     */
    public function setEndpoint(AbstractEndpoint $endpoint)
    {
        $this->endpoint = $endpoint;
    }

    /**
     *
     * @return AbstractEndpoint $endpoint
     */
    public function getEndpoint()
    {
        return $this->endpoint;
    }

    /**
     *
     * @param multitype:FileParameter $fileParameters
     */
    public function setFileParameters(array $fileParameters)
    {
        $this->fileParameters = $fileParameters;
    }

    /**
     *
     * @return FileParameter[] $fileParameters
     */
    public function getFileParameters()
    {
        return $this->fileParameters;
    }

}
