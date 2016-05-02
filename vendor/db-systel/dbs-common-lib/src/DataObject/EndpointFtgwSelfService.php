<?php
namespace DbSystel\DataObject;

class EndpointFtgwSelfService extends AbstractEndpoint
{

    const CONNECTION_TYPE_INTERNAL = 'internal';

    const CONNECTION_TYPE_EXTERNAL = 'external';

    /**
     *
     * @var Protocol[]
     */
    protected $protocols;

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
     * @return the $protocols
     */
    public function getProtocols()
    {
        return $this->protocols;
    }

    /**
     *
     * @param multitype:Protocol $protocols
     */
    public function setProtocols(array $protocols)
    {
        $this->protocols = $protocols;
    }

    /**
     *
     * @return the $ftgwUsername
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
     * @return the $mailbox
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
     * @return the $connectionType
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

}
