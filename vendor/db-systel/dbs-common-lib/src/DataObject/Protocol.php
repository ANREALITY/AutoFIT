<?php
namespace DbSystel\DataObject;

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
     * @var int
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
     * @return int $id
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     *
     * @param number $id
     */
    public function setId($id)
    {
        $this->id = $id;
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
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     *
     * @return ProtocolSet $protocolSet
     */
    public function getProtocolSet()
    {
        return $this->protocolSet;
    }

    /**
     *
     * @param ProtocolSet $protocolSet
     */
    public function setProtocolSet(ProtocolSet $protocolSet)
    {
        $this->protocolSet = $protocolSet;
    }

}