<?php
namespace DbSystel\DataObject;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * FileParameterSet
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
     * @var ArrayCollection
     */
    private $fileParameters;

    public function __construct()
    {
        $this->fileParameters = new ArrayCollection();
    }

    /**
     * @param integer $id
     *
     * @return FileParameterSet
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param AbstractEndpoint $endpoint
     *
     * @return FileParameterSet
     */
    public function setEndpoint(AbstractEndpoint $endpoint)
    {
        $this->endpoint = $endpoint;

        return $this;
    }

    /**
     * @return AbstractEndpoint
     */
    public function getEndpoint()
    {
        return $this->endpoint;
    }

    /**
     * @param ArrayCollection $fileParameters
     *
     * @return FileParameterSet
     */
    public function setFileParameters($fileParameters)
    {
        $this->fileParameters = $fileParameters;

        return $this;
    }

    /**
     * @return ArrayCollection $fileParameters
     */
    public function getFileParameters()
    {
        return $this->fileParameters;
    }

    /**
     * @param FileParameter $fileParameter
     * @return FileParameterSet
     */
    public function addFileParameter(FileParameter $fileParameter)
    {
        $this->fileParameters->add($fileParameter);
        return $this;
    }

    /**
     * @param FileParameter $fileParameter
     * @return FileParameterSet
     */
    public function removeFileParameter(FileParameter $fileParameter)
    {
        $this->fileParameters->removeElement($fileParameter);
        return $this;
    }

}
