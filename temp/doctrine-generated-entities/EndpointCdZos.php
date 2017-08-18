<?php
namespace DbSystel\DataObject;

use Doctrine\ORM\Mapping as ORM;

/**
 * EndpointCdZos
 *
 * @ORM\Table(name="endpoint_cd_zos", indexes={@ORM\Index(name="fk_endpoint_cd_zos_file_parameter_set_idx", columns={"file_parameter_set_id"})})
 * @ORM\Entity
 */
class EndpointCdZos extends AbstractDataObject
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
     * @return EndpointCdZos
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
     * @return EndpointCdZos
     */
    public function setEndpoint(\Endpoint $endpoint)
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
     * @return EndpointCdZos
     */
    public function setFileParameterSet(\FileParameterSet $fileParameterSet = null)
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
