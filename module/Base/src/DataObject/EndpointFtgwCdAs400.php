<?php
namespace Base\DataObject;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * EndpointFtgwCdAs400
 *
 * @ORM\Table(name="endpoint_ftgw_cd_as400")
 * @ORM\Entity
 */
class EndpointFtgwCdAs400 extends AbstractEndpoint
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
     * @return EndpointFtgwCdAs400
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
     * @return EndpointFtgwCdAs400
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
