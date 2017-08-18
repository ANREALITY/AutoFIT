<?php
namespace DbSystel\DataObject;

use Doctrine\ORM\Mapping as ORM;

/**
 * EndpointCdLinuxUnix
 *
 * @ORM\Table(name="endpoint_cd_linux_unix", indexes={@ORM\Index(name="fk_endpoint_cd_linux_unix_include_parameter_set_idx", columns={"include_parameter_set_id"}), @ORM\Index(name="fk_endpoint_cd_linux_unix_endpoint_cluster_config_idx", columns={"endpoint_cluster_config_id"})})
 * @ORM\Entity
 */
class EndpointCdLinuxUnix extends AbstractEndpoint
{

    /**
     * @var string
     *
     * @ORM\Column(name="username", type="string", length=50, nullable=true)
     */
    private $username;

    /**
     * @var string
     *
     * @ORM\Column(name="folder", type="string", length=200, nullable=true)
     */
    private $folder;

    /**
     * @var string
     *
     * @ORM\Column(name="transmission_type", type="string", nullable=true)
     */
    private $transmissionType;

    /**
     * @var string
     *
     * @ORM\Column(name="transmission_interval", type="string", length=50, nullable=true)
     */
    private $transmissionInterval;

    /**
     * @var AbstractEndpoint
     *
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     * @ORM\OneToOne(targetEntity="AbstractEndpoint")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="endpoint_id", referencedColumnName="id")
     * })
     */
    private $endpoint;

    /**
     * @var EndpointClusterConfig
     *
     * @ORM\ManyToOne(targetEntity="EndpointClusterConfig")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="endpoint_cluster_config_id", referencedColumnName="id")
     * })
     */
    private $endpointClusterConfig;

    /**
     * @var IncludeParameterSet
     *
     * @ORM\ManyToOne(targetEntity="IncludeParameterSet")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="include_parameter_set_id", referencedColumnName="id")
     * })
     */
    private $includeParameterSet;



    /**
     * @param string $username
     *
     * @return EndpointCdLinuxUnix
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
     * @return EndpointCdLinuxUnix
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
     * @return EndpointCdLinuxUnix
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
     * @return EndpointCdLinuxUnix
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
     * @param AbstractEndpoint $endpoint
     *
     * @return EndpointCdLinuxUnix
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
     * @param EndpointClusterConfig $endpointClusterConfig
     *
     * @return EndpointCdLinuxUnix
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

    /**
     * @param IncludeParameterSet $includeParameterSet
     *
     * @return EndpointCdLinuxUnix
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

}
