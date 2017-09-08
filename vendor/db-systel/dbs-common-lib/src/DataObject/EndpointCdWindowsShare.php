<?php
namespace DbSystel\DataObject;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * EndpointCdWindowsShare
 *
 * @ORM\Table(
 *     name="endpoint_cd_windows_share",
 *     indexes={
 *         @ORM\Index(name="fk_endpoint_cd_windows_share_include_parameter_set_idx", columns={"include_parameter_set_id"}),
 *         @ORM\Index(name="fk_endpoint_cd_windows_share_access_config_set_idx", columns={"access_config_set_id"})
 *     }
 * )
 * @ORM\Entity
 */
class EndpointCdWindowsShare extends AbstractEndpoint
{

    /** @var string */
    const TRANSMISSION_TYPE_TXT = 'txt';
    /** @var string */
    const TRANSMISSION_TYPE_BIN = 'bin';

    /**
     * @var string
     *
     * @ORM\Column(name="sharename", type="string", length=50, nullable=true)
     */
    protected $sharename;

    /**
     * @var string
     *
     * @ORM\Column(name="folder", type="string", length=200, nullable=true)
     */
    protected $folder;

    /**
     * @var string
     *
     * @ORM\Column(name="transmission_type", type="string", nullable=true)
     */
    protected $transmissionType;

    /**
     * @var IncludeParameterSet
     *
     * @ORM\OneToOne(targetEntity="IncludeParameterSet")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="include_parameter_set_id", referencedColumnName="id")
     * })
     */
    protected $includeParameterSet;

    /**
     * @var AccessConfigSet
     *
     * @ORM\OneToOne(targetEntity="AccessConfigSet")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="access_config_set_id", referencedColumnName="id")
     * })
     */
    protected $accessConfigSet;

    /**
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
     * @return string
     */
    public function getSharename()
    {
        return $this->sharename;
    }

    /**
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
     * @return string
     */
    public function getFolder()
    {
        return $this->folder;
    }

    /**
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
     * @return string
     */
    public function getTransmissionType()
    {
        return $this->transmissionType;
    }

    /**
     * @param IncludeParameterSet $includeParameterSet
     *
     * @return EndpointCdWindowsShare
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
     * @param AccessConfigSet $accessConfigSet
     *
     * @return EndpointCdWindowsShare
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

}
