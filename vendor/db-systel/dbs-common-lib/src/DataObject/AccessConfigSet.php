<?php
namespace DbSystel\DataObject;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * AccessConfigSet
 *
 * @ORM\Table(name="access_config_set")
 * @ORM\Entity
 */
class AccessConfigSet extends AbstractDataObject
{

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var AbstractEndpoint
     */
    private $endpoint;

    /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="AccessConfig", mappedBy="accessConfigSet", cascade={"all"})
     */
    private $accessConfigs;

    public function __construct()
    {
        $this->accessConfigs = new ArrayCollection();
    }

    /**
     * @param integer $id
     *
     * @return AccessConfigSet
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
     * @return AccessConfigSet
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
     * @param ArrayCollection $accessConfigs
     *
     * @return AccessConfigSet
     */
    public function setAccessConfigs($accessConfigs)
    {
        $this->accessConfigs = $accessConfigs;

        return $this;
    }

    /**
     * @return ArrayCollection $accessConfigs
     */
    public function getAccessConfigs()
    {
        return $this->accessConfigs;
    }

    /**
     * @param AccessConfig $accessConfig
     * @return AccessConfigSet
     */
    public function addAccessConfig(AccessConfig $accessConfig)
    {
        $this->accessConfigs->add($accessConfig);
        return $this;
    }

    /**
     * @param AccessConfig $property
     * @return AccessConfigSet
     */
    public function removeAccessConfig(AccessConfig $property)
    {
        $this->accessConfigs->removeElement($property);
        return $this;
    }

}
