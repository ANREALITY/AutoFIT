<?php
namespace DbSystel\DataObject;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * FileParameterSet
 *
 * @ORM\Table(name="file_parameter_set")
 * @ORM\Entity
 */
class FileParameterSet extends AbstractDataObject
{

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    protected $id;

    /**
     * @var AbstractEndpoint
     */
    protected $endpoint;

    /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="FileParameter", mappedBy="fileParameterSet", orphanRemoval=true)
     *
     * @Groups({"export"})
     */
    protected $fileParameters;

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
        $this->removeFileParametersNotInList($fileParameters);
        $this->fileParameters = new ArrayCollection([]);
        /** @var FileParameter $fileParameter */
        foreach ($fileParameters as $fileParameter) {
            $this->addFileParameter($fileParameter);
        }
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
        $fileParameter->setFileParameterSet($this);
        return $this;
    }

    /**
     * @param FileParameter $fileParameter
     * @return FileParameterSet
     */
    public function removeFileParameter(FileParameter $fileParameter)
    {
        $this->fileParameters->removeElement($fileParameter);
        $fileParameter->setFileParameterSet(null);
        return $this;
    }

    /**
     * @param $fileParameters
     * @return void
     */
    private function removeFileParametersNotInList($fileParameters)
    {
        if (is_array($fileParameters)) {
            $fileParameters = new ArrayCollection($fileParameters);
        }
        foreach ($this->getFileParameters() as $fileParameter) {
            if ($fileParameters->indexOf($fileParameter) === false) {
                $this->removeFileParameter($fileParameter);
            }
        }
    }

}
