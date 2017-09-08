<?php
namespace DbSystel\DataObject;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * Protocol
 *
 * @ORM\Table(
 *     name="protocol",
 *     indexes={
 *         @ORM\Index(name="fk_protocol_protocol_set_idx", columns={"protocol_set_id"})
 *     }
 * )
 * @ORM\Entity
 */
class Protocol extends AbstractDataObject
{

    /**
     * @var array
     */
    const PROTOCOLS = [
        'FTP' => 'FTP',
        'FTPs' => 'FTPs',
        'SFTP' => 'SFTP',
        // 'HTTP' => 'HTTP',
        'HTTPs' => 'HTTPs',
        'WebDAV' => 'WebDAV'
    ];

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    protected $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", nullable=true)
     *
     * @Groups({"export"})
     */
    protected $name;

    /**
     * @var ProtocolSet
     *
     * @ORM\ManyToOne(targetEntity="ProtocolSet", inversedBy="protocols")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="protocol_set_id", referencedColumnName="id")
     * })
     */
    protected $protocolSet;

    /**
     * @param integer $id
     *
     * @return Protocol
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param string $name
     *
     * @return Protocol
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param ProtocolSet $protocolSet
     *
     * @return Protocol
     */
    public function setProtocolSet(ProtocolSet $protocolSet = null)
    {
        $this->protocolSet = $protocolSet;

        return $this;
    }

    /**
     * @return ProtocolSet
     */
    public function getProtocolSet()
    {
        return $this->protocolSet;
    }

}