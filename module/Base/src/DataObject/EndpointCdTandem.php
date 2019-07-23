<?php
namespace Base\DataObject;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * EndpointCdTandem
 *
 * @ORM\Table(name="endpoint_cd_tandem")
 * @ORM\Entity
 */
class EndpointCdTandem extends AbstractEndpoint
{

    /**
     * @var string
     *
     * @ORM\Column(name="username", type="string", length=50, nullable=true)
     *
     * @Groups({"export"})
     */
    protected $username;

    /**
     * @var string
     *
     * @ORM\Column(name="folder", type="string", length=200, nullable=true)
     *
     * @Groups({"export"})
     */
    protected $folder;

    /**
     * @param string $username
     *
     * @return EndpointCdTandem
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
     * @return EndpointCdTandem
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

}
