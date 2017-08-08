<?php
namespace DbSystel\DataObject;

class EndpointFtgwSelfService extends AbstractEndpoint
{

    const CONNECTION_TYPE_INTERNAL = 'internal';

    const CONNECTION_TYPE_EXTERNAL = 'external';

    const CONNECTION_TYPE_BOTH = 'both';

    /**
     *
     * @var string
     */
    protected $ftgwUsername;

    /**
     *
     * @var string
     */
    protected $mailbox;

    /**
     *
     * @var string
     */
    protected $connectionType;

    /**
     *
     * @var ProtocolSet
     */
    protected $protocolSet;

    /**
     *
     * @return string $ftgwUsername
     */
    public function getFtgwUsername()
    {
        return $this->ftgwUsername;
    }

    /**
     *
     * @param string $ftgwUsername
     */
    public function setFtgwUsername($ftgwUsername)
    {
        $this->ftgwUsername = $ftgwUsername;
    }

    /**
     *
     * @return string $mailbox
     */
    public function getMailbox()
    {
        return $this->mailbox;
    }

    /**
     *
     * @param string $mailbox
     */
    public function setMailbox($mailbox)
    {
        $this->mailbox = $mailbox;
    }

    /**
     *
     * @return string $connectionType
     */
    public function getConnectionType()
    {
        return $this->connectionType;
    }

    /**
     *
     * @param string $connectionType
     */
    public function setConnectionType($connectionType)
    {
        $this->connectionType = $connectionType;
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
