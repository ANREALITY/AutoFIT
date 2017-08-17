<?php
namespace DbSystel\DataObject;

/**
 * Class Protocol
 *
 * @package DbSystel\DataObject
 */
class Protocol extends AbstractDataObject
{

    /**
     *
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
     *
     * @var integer
     */
    protected $id;

    /**
     *
     * @var string
     */
    protected $name;

    /**
     *
     * @var ProtocolSet
     */
    protected $protocolSet;

    /**
     *
     * @param integer $id
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     *
     * @return integer $id
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     *
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     *
     * @return string $name
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     *
     * @param ProtocolSet $protocolSet
     */
    public function setProtocolSet(ProtocolSet $protocolSet)
    {
        $this->protocolSet = $protocolSet;

        return $this;
    }

    /**
     *
     * @return ProtocolSet $protocolSet
     */
    public function getProtocolSet()
    {
        return $this->protocolSet;
    }

}