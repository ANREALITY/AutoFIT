<?php



use Doctrine\ORM\Mapping as ORM;

/**
 * EndpointFtgwCdTandem
 *
 * @ORM\Table(name="endpoint_ftgw_cd_tandem")
 * @ORM\Entity
 */
class EndpointFtgwCdTandem
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
     * Set username
     *
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
     * @return EndpointFtgwCdTandem
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
     * Set endpoint
     *
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
     * Get endpoint
     *
     * @return \Endpoint
     */
    public function getEndpoint()
    {
        return $this->endpoint;
    }
}
