<?php
namespace DbSystel\DataObject;

use Doctrine\ORM\Mapping as ORM;

/**
 * Protocol
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
     */
    private $id;

    /**
     * @var string
     */
    private $name;

    /**
     * @var ProtocolSet
     */
    private $protocolSet;

    /**
     * @param integer $id
     * @return Protocol
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @return integer $id
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param string $name
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
     * @return Protocol
     */
    public function setProtocolSet(ProtocolSet $protocolSet)
    {
        $this->protocolSet = $protocolSet;

        return $this;
    }

    /**
     * @return ProtocolSet $protocolSet
     */
    public function getProtocolSet()
    {
        return $this->protocolSet;
    }

}