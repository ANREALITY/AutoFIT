<?php
namespace DbSystel\DataObject;

/**
 * Class EndpointFtgwSelfService
 *
 * @package DbSystel\DataObject
 */
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
     * @param string $ftgwUsername
     */
    public function setFtgwUsername($ftgwUsername)
    {
        $this->ftgwUsername = $ftgwUsername;

        return $this;
    }

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
     * @param string $mailbox
     */
    public function setMailbox($mailbox)
    {
        $this->mailbox = $mailbox;

        return $this;
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
     * @param string $connectionType
     */
    public function setConnectionType($connectionType)
    {
        $this->connectionType = $connectionType;

        return $this;
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
