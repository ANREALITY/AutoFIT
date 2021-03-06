<?php
namespace Base\DataObject;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * EndpointFtgwWindowsShare
 *
 * @ORM\Table(
 *     name="endpoint_ftgw_windows_share",
 *     indexes={
 *         @ORM\Index(name="fk_endpoint_ftgw_windows_share_include_parameter_set_idx", columns={"include_parameter_set_id"}),
 *         @ORM\Index(name="fk_endpoint_ftgw_windows_share_access_config_set_idx", columns={"access_config_set_id"})
 *     }
 * )
 * @ORM\Entity
 */
class EndpointFtgwWindowsShare extends AbstractEndpoint
{

    /**
     * @var string
     *
     * @ORM\Column(name="sharename", type="string", length=50, nullable=true)
     *
     * @Groups({"export"})
     */
    protected $sharename;

    /**
     * @var string
     *
     * @ORM\Column(name="folder", type="string", length=200, nullable=true)
     *
     * @Groups({"export"})
     */
    protected $folder;

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
     * @var AccessConfigSet
     *
     * @ORM\OneToOne(targetEntity="AccessConfigSet", cascade={"persist"})
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="access_config_set_id", referencedColumnName="id")
     * })
     *
     * @Groups({"export"})
     */
    protected $accessConfigSet;

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
     * @param IncludeParameterSet $includeParameterSet
     *
     * @return EndpointFtgwWindowsShare
     */
    public function setIncludeParameterSet(IncludeParameterSet $includeParameterSet)
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
     * @return EndpointFtgwWindowsShare
     */
    public function setAccessConfigSet(AccessConfigSet $accessConfigSet)
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
