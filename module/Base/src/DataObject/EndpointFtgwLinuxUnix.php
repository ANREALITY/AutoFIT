<?php
namespace Base\DataObject;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * EndpointFtgwLinuxUnix
 *
 * @ORM\Table(
 *     name="endpoint_ftgw_linux_unix",
 *     indexes={
 *         @ORM\Index(name="fk_endpoint_ftgw_linux_unix_include_parameter_set_idx", columns={"include_parameter_set_id"}),
 *         @ORM\Index(name="fk_endpoint_ftgw_linux_unix_endpoint_cluster_config_idx", columns={"endpoint_cluster_config_id"})
 *     }
 * )
 * @ORM\Entity
 */
class EndpointFtgwLinuxUnix extends AbstractEndpoint
{

    /** @var string */
    const TRANSMISSION_TYPE_TXT = 'txt';
    /** @var string */
    const TRANSMISSION_TYPE_BIN = 'bin';

    /**
     * @var string
     *
     * @ORM\Column(name="username", type="string", length=50, nullable=true)
     *
     * @Groups({"export"})
     */
    protected $username;

    /**
     * @var string
     *
     * @ORM\Column(name="folder", type="string", length=200, nullable=true)
     *
     * @Groups({"export"})
     */
    protected $folder;

    /**
     * @var string
     *
     * @ORM\Column(name="transmission_type", type="string", nullable=true)
     *
     * @Groups({"export"})
     */
    protected $transmissionType;

    /**
     * @var string
     *
     * @ORM\Column(name="transmission_interval", type="string", length=50, nullable=true)
     *
     * @Groups({"export"})
     */
    protected $transmissionInterval;

    /**
     * @var IncludeParameterSet
     *
     * @ORM\OneToOne(targetEntity="IncludeParameterSet", cascade={"persist"})
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="include_parameter_set_id", referencedColumnName="id")
     * })
     *
     * @Groups({"export"})
     */
    protected $includeParameterSet;

    /**
     * @var EndpointClusterConfig
     *
     * @ORM\OneToOne(targetEntity="EndpointClusterConfig", cascade={"persist"})
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="endpoint_cluster_config_id", referencedColumnName="id")
     * })
     *
     * @Groups({"export"})
     */
    protected $endpointClusterConfig;

    /**
     * @param string $username
     *
     * @return EndpointFtgwLinuxUnix
     */
    public function setUsername($username)
    {
        $this->username = $username;

        return $this;
    }

    /**
     * @return string
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * @param string $folder
     *
     * @return EndpointFtgwLinuxUnix
     */
    public function setFolder($folder)
    {
        $this->folder = $folder;

        return $this;
    }

    /**
     * @return string
     */
    public function getFolder()
    {
        return $this->folder;
    }

    /**
     * @param string $transmissionType
     *
     * @return EndpointFtgwLinuxUnix
     */
    public function setTransmissionType($transmissionType)
    {
        $this->transmissionType = $transmissionType;

        return $this;
    }

    /**
     * @return string
     */
    public function getTransmissionType()
    {
        return $this->transmissionType;
    }

    /**
     * @param string $transmissionInterval
     *
     * @return EndpointFtgwLinuxUnix
     */
    public function setTransmissionInterval($transmissionInterval)
    {
        $this->transmissionInterval = $transmissionInterval;

        return $this;
    }

    /**
     * @return string
     */
    public function getTransmissionInterval()
    {
        return $this->transmissionInterval;
    }

    /**
     * @param IncludeParameterSet $includeParameterSet
     *
     * @return EndpointFtgwLinuxUnix
     */
    public function setIncludeParameterSet(IncludeParameterSet $includeParameterSet = null)
    {
        $this->includeParameterSet = $includeParameterSet;

        return $this;
    }

    /**
     * @return IncludeParameterSet
     */
    public function getIncludeParameterSet()
    {
        return $this->includeParameterSet;
    }

    /**
     * @param EndpointClusterConfig $endpointClusterConfig
     *
     * @return EndpointFtgwLinuxUnix
     */
    public function setEndpointClusterConfig(EndpointClusterConfig $endpointClusterConfig = null)
    {
        $this->endpointClusterConfig = $endpointClusterConfig;

        return $this;
    }

    /**
     * @return EndpointClusterConfig
     */
    public function getEndpointClusterConfig()
    {
        return $this->endpointClusterConfig;
    }

}
