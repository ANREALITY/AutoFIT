<?php
namespace DbSystel\DataObject;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * EndpointCdZos
 *
 * @ORM\Table(
 *     name="endpoint_cd_zos",
 *     indexes={
 *         @ORM\Index(name="fk_endpoint_cd_zos_file_parameter_set_idx", columns={"file_parameter_set_id"})
 *     }
 * )
 * @ORM\Entity
 */
class EndpointCdZos extends AbstractEndpoint
{

    /**
     * @var string
     *
     * @ORM\Column(name="username", type="string", length=50, nullable=true)
     */
    protected $username;

    /**
     * @var FileParameterSet
     *
     * @ORM\OneToOne(targetEntity="FileParameterSet")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="file_parameter_set_id", referencedColumnName="id")
     * })
     */
    protected $fileParameterSet;

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
     * @param FileParameterSet $fileParameterSet
     *
     * @return EndpointCdZos
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
