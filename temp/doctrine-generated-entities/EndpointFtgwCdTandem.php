<?php
namespace DbSystel\DataObject;

use Doctrine\ORM\Mapping as ORM;

/**
 * EndpointFtgwCdTandem
 *
 * @ORM\Table(name="endpoint_ftgw_cd_tandem")
 * @ORM\Entity
 */
class EndpointFtgwCdTandem extends AbstractDataObject
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
     * @param string $username
     *
     * @return EndpointFtgwCdTandem
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
     * @return EndpointFtgwCdTandem
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
     * @param \Endpoint $endpoint
     *
     * @return EndpointFtgwCdTandem
     */
    public function setEndpoint(\Endpoint $endpoint)
    {
        $this->endpoint = $endpoint;

        return $this;
    }

    /**
     * @return \Endpoint
     */
    public function getEndpoint()
    {
        return $this->endpoint;
    }
}
