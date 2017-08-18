<?php



use Doctrine\ORM\Mapping as ORM;

/**
 * EndpointCdWindowsShare
 *
 * @ORM\Table(name="endpoint_cd_windows_share", indexes={@ORM\Index(name="fk_endpoint_cd_windows_share_include_parameter_set_idx", columns={"include_parameter_set_id"}), @ORM\Index(name="fk_endpoint_cd_windows_share_access_config_set_idx", columns={"access_config_set_id"})})
 * @ORM\Entity
 */
class EndpointCdWindowsShare
{
    /**
     * @var string
     *
     * @ORM\Column(name="sharename", type="string", length=50, nullable=true)
     */
    private $sharename;

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
     * @var \AccessConfigSet
     *
     * @ORM\ManyToOne(targetEntity="AccessConfigSet")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="access_config_set_id", referencedColumnName="id")
     * })
     */
    private $accessConfigSet;

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
     * @var \IncludeParameterSet
     *
     * @ORM\ManyToOne(targetEntity="IncludeParameterSet")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="include_parameter_set_id", referencedColumnName="id")
     * })
     */
    private $includeParameterSet;



    /**
     * Set sharename
     *
     * @param string $sharename
     *
     * @return EndpointCdWindowsShare
     */
    public function setSharename($sharename)
    {
        $this->sharename = $sharename;

        return $this;
    }

    /**
     * Get sharename
     *
     * @return string
     */
    public function getSharename()
    {
        return $this->sharename;
    }

    /**
     * Set folder
     *
     * @param string $folder
     *
     * @return EndpointCdWindowsShare
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
     * @return EndpointCdWindowsShare
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
     * Set accessConfigSet
     *
     * @param \AccessConfigSet $accessConfigSet
     *
     * @return EndpointCdWindowsShare
     */
    public function setAccessConfigSet(\AccessConfigSet $accessConfigSet = null)
    {
        $this->accessConfigSet = $accessConfigSet;

        return $this;
    }

    /**
     * Get accessConfigSet
     *
     * @return \AccessConfigSet
     */
    public function getAccessConfigSet()
    {
        return $this->accessConfigSet;
    }

    /**
     * Set endpoint
     *
     * @param \Endpoint $endpoint
     *
     * @return EndpointCdWindowsShare
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
     * Set includeParameterSet
     *
     * @param \IncludeParameterSet $includeParameterSet
     *
     * @return EndpointCdWindowsShare
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
