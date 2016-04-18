<?php
namespace DbSystel\DataObject;

class EndpointFtgwSelfService extends AbstractEndpoint
{

    /**
     *
     * @var string
     */
    protected $protocol;

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
     * @return the $protocol
     */
    public function getProtocol()
    {
        return $this->protocol;
    }

    /**
     *
     * @param string $protocol
     */
    public function setProtocol($protocol)
    {
        $this->protocol = $protocol;
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

}
