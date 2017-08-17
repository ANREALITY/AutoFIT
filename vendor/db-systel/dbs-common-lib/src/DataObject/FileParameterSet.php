<?php
namespace DbSystel\DataObject;

/**
 * Class FileParameterSet
 *
 * @package DbSystel\DataObject
 */
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
     * @param integer $id
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
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

        return $this;
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

        return $this;
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
