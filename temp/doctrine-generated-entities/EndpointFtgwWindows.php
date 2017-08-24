<?php
namespace DbSystel\DataObject;

use Doctrine\ORM\Mapping as ORM;

/**
 * EndpointFtgwWindows
 *
 * @ORM\Table(name="endpoint_ftgw_windows", indexes={@ORM\Index(name="fk_endpoint_ftgw_windows_endpoint_idx", columns={"endpoint_id"}), @ORM\Index(name="fk_endpoint_ftgw_windows_include_parameter_set_idx", columns={"include_parameter_set_id"})})
 * @ORM\Entity
 */
class EndpointFtgwWindows extends AbstractEndpoint
{

    /**
     * @var string
     *
     * @ORM\Column(name="folder", type="string", length=200, nullable=true)
     */
    private $folder;

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
     * @param string $folder
     *
     * @return EndpointFtgwWindows
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
     * @return EndpointFtgwWindows
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
