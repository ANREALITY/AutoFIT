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
     * @var integer
     */
    private $id;

    /**
     * @var AbstractEndpoint
     */
    private $endpoint;

    /**
     * @var FileParameter[]
     */
    private $fileParameters;

    /**
     * @param integer $id
     * @return FileParameterSet
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
     * @param AbstractEndpoint $endpoint
     * @return FileParameterSet
     */
    public function setEndpoint(AbstractEndpoint $endpoint)
    {
        $this->endpoint = $endpoint;

        return $this;
    }

    /**
     * @return AbstractEndpoint $endpoint
     */
    public function getEndpoint()
    {
        return $this->endpoint;
    }

    /**
     * @param FileParameter[] $fileParameters
     * @return FileParameterSet
     */
    public function setFileParameters(array $fileParameters)
    {
        $this->fileParameters = $fileParameters;

        return $this;
    }

    /**
     * @return FileParameter[] $fileParameters
     */
    public function getFileParameters()
    {
        return $this->fileParameters;
    }

}
