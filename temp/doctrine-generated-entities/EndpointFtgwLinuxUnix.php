<?php
namespace DbSystel\DataObject;

use Doctrine\ORM\Mapping as ORM;

/**
 * EndpointFtgwLinuxUnix
 *
 * @ORM\Table(name="endpoint_ftgw_linux_unix", indexes={@ORM\Index(name="fk_endpoint_ftgw_linux_unix_include_parameter_set_idx", columns={"include_parameter_set_id"}), @ORM\Index(name="fk_endpoint_ftgw_linux_unix_endpoint_cluster_config_idx", columns={"endpoint_cluster_config_id"})})
 * @ORM\Entity
 */
class EndpointFtgwLinuxUnix extends AbstractDataObject
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
     * @var \Endpoint
     *
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     * @ORM\OneToOne(targetEntity="Endpoint")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="endpoint_id", referencedColumnName="id")
     * })
     */
    private $endpoint;

    /**
     * @var \EndpointClusterConfig
     *
     * @ORM\ManyToOne(targetEntity="EndpointClusterConfig")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="endpoint_cluster_config_id", referencedColumnName="id")
     * })
     */
    private $endpointClusterConfig;

    /**
     * @var \IncludeParameterSet
     *
     * @ORM\ManyToOne(targetEntity="IncludeParameterSet")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="include_parameter_set_id", referencedColumnName="id")
     * })
     */
    private $includeParameterSet;



    /**
     * Set username
     *
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
     * Get username
     *
     * @return string
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * Set folder
     *
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
     * Get folder
     *
     * @return string
     */
    public function getFolder()
    {
        return $this->folder;
    }

    /**
     * Set transmissionType
     *
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
     * Get transmissionType
     *
     * @return string
     */
    public function getTransmissionType()
    {
        return $this->transmissionType;
    }

    /**
     * Set transmissionInterval
     *
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
     * Get transmissionInterval
     *
     * @return string
     */
    public function getTransmissionInterval()
    {
        return $this->transmissionInterval;
    }

    /**
     * Set endpoint
     *
     * @param \Endpoint $endpoint
     *
     * @return EndpointFtgwLinuxUnix
     */
    public function setEndpoint(\Endpoint $endpoint)
    {
        $this->endpoint = $endpoint;

        return $this;
    }

    /**
     * Get endpoint
     *
     * @return \Endpoint
     */
    public function getEndpoint()
    {
        return $this->endpoint;
    }

    /**
     * Set endpointClusterConfig
     *
     * @param \EndpointClusterConfig $endpointClusterConfig
     *
     * @return EndpointFtgwLinuxUnix
     */
    public function setEndpointClusterConfig(\EndpointClusterConfig $endpointClusterConfig = null)
    {
        $this->endpointClusterConfig = $endpointClusterConfig;

        return $this;
    }

    /**
     * Get endpointClusterConfig
     *
     * @return \EndpointClusterConfig
     */
    public function getEndpointClusterConfig()
    {
        return $this->endpointClusterConfig;
    }

    /**
     * Set includeParameterSet
     *
     * @param \IncludeParameterSet $includeParameterSet
     *
     * @return EndpointFtgwLinuxUnix
     */
    public function setIncludeParameterSet(\IncludeParameterSet $includeParameterSet = null)
    {
        $this->includeParameterSet = $includeParameterSet;

        return $this;
    }

    /**
     * Get includeParameterSet
     *
     * @return \IncludeParameterSet
     */
    public function getIncludeParameterSet()
    {
        return $this->includeParameterSet;
    }
}
