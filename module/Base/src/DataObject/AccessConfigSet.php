<?php
namespace Base\DataObject;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

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
    protected $id;

    /**
     * @var AbstractEndpoint
     */
    protected $endpoint;

    /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="AccessConfig", mappedBy="accessConfigSet", cascade={"persist"}, orphanRemoval=true)
     *
     * @Groups({"export"})
     */
    protected $accessConfigs;

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
        $this->removeAccessConfigsNotInList($accessConfigs);
        $this->accessConfigs = new ArrayCollection([]);
        /** @var AccessConfig $accessConfig */
        foreach ($accessConfigs as $accessConfig) {
            $this->addAccessConfig($accessConfig);
        }
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
        $accessConfig->setAccessConfigSet($this);
        return $this;
    }

    /**
     * @param AccessConfig $accessConfig
     * @return AccessConfigSet
     */
    public function removeAccessConfig(AccessConfig $accessConfig)
    {
        $this->accessConfigs->removeElement($accessConfig);
        $accessConfig->setAccessConfigSet(null);
        return $this;
    }

    /**
     * @param $accessConfigs
     * @return void
     */
    private function removeAccessConfigsNotInList($accessConfigs)
    {
        if (is_array($accessConfigs)) {
            $accessConfigs = new ArrayCollection($accessConfigs);
        }
        foreach ($this->getAccessConfigs() as $accessConfig) {
            if ($accessConfigs->indexOf($accessConfig) === false) {
                $this->removeAccessConfig($accessConfig);
            }
        }
    }

}
