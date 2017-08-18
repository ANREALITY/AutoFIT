<?php
namespace DbSystel\DataObject;

use Doctrine\ORM\Mapping as ORM;

/**
 * EndpointFtgwCdZos
 *
 * @ORM\Table(name="endpoint_ftgw_cd_zos", indexes={@ORM\Index(name="fk_endpoint_ftgw_cd_zos_file_parameter_set_idx", columns={"file_parameter_set_id"})})
 * @ORM\Entity
 */
class EndpointFtgwCdZos extends AbstractDataObject
{
    /**
     * @var string
     *
     * @ORM\Column(name="username", type="string", length=50, nullable=true)
     */
    private $username;

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
     * @var FileParameterSet
     *
     * @ORM\ManyToOne(targetEntity="FileParameterSet")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="file_parameter_set_id", referencedColumnName="id")
     * })
     */
    private $fileParameterSet;



    /**
     * @param string $username
     *
     * @return EndpointFtgwCdZos
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
     * @param Endpoint $endpoint
     *
     * @return EndpointFtgwCdZos
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
     * @param FileParameterSet $fileParameterSet
     *
     * @return EndpointFtgwCdZos
     */
    public function setFileParameterSet(FileParameterSet $fileParameterSet = null)
    {
        $this->fileParameterSet = $fileParameterSet;

        return $this;
    }

    /**
     * @return FileParameterSet
     */
    public function getFileParameterSet()
    {
        return $this->fileParameterSet;
    }
}
