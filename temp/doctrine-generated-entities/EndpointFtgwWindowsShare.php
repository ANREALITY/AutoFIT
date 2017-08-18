<?php
namespace DbSystel\DataObject;

use Doctrine\ORM\Mapping as ORM;

/**
 * EndpointFtgwWindowsShare
 *
 * @ORM\Table(name="endpoint_ftgw_windows_share", indexes={@ORM\Index(name="fk_endpoint_ftgw_windows_share_include_parameter_set_idx", columns={"include_parameter_set_id"}), @ORM\Index(name="fk_endpoint_ftgw_windows_share_access_config_set_idx", columns={"access_config_set_id"})})
 * @ORM\Entity
 */
class EndpointFtgwWindowsShare extends AbstractDataObject
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
     * @var AccessConfigSet
     *
     * @ORM\ManyToOne(targetEntity="AccessConfigSet")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="access_config_set_id", referencedColumnName="id")
     * })
     */
    private $accessConfigSet;

    /**
     * @var Endpoint
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
     * @var IncludeParameterSet
     *
     * @ORM\ManyToOne(targetEntity="IncludeParameterSet")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="include_parameter_set_id", referencedColumnName="id")
     * })
     */
    private $includeParameterSet;



    /**
     * @param string $sharename
     *
     * @return EndpointFtgwWindowsShare
     */
    public function setSharename($sharename)
    {
        $this->sharename = $sharename;

        return $this;
    }

    /**
     * @return string
     */
    public function getSharename()
    {
        return $this->sharename;
    }

    /**
     * @param string $folder
     *
     * @return EndpointFtgwWindowsShare
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
     * @param AccessConfigSet $accessConfigSet
     *
     * @return EndpointFtgwWindowsShare
     */
    public function setAccessConfigSet(AccessConfigSet $accessConfigSet = null)
    {
        $this->accessConfigSet = $accessConfigSet;

        return $this;
    }

    /**
     * @return AccessConfigSet
     */
    public function getAccessConfigSet()
    {
        return $this->accessConfigSet;
    }

    /**
     * @param Endpoint $endpoint
     *
     * @return EndpointFtgwWindowsShare
     */
    public function setEndpoint(Endpoint $endpoint)
    {
        $this->endpoint = $endpoint;

        return $this;
    }

    /**
     * @return Endpoint
     */
    public function getEndpoint()
    {
        return $this->endpoint;
    }

    /**
     * @param IncludeParameterSet $includeParameterSet
     *
     * @return EndpointFtgwWindowsShare
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
