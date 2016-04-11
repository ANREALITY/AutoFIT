<?php
namespace DbSystel\DataObject;

class EndpointFtgwSelfService extends AbstractEndpoint
{

    /**
     *
     * @var boolean
     */
    protected $notificationSuccess;

    /**
     *
     * @var string
     */
    protected $emailSuccess;

    /**
     *
     * @var boolean
     */
    protected $notificationFailure;

    /**
     *
     * @var string
     */
    protected $emailFailure;

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
     * @return the $notificationSuccess
     */
    public function getNotificationSuccess()
    {
        return $this->notificationSuccess;
    }

    /**
     *
     * @param boolean $notificationSuccess
     */
    public function setNotificationSuccess($notificationSuccess)
    {
        $this->notificationSuccess = $notificationSuccess;
    }

    /**
     *
     * @return the $emailSuccess
     */
    public function getEmailSuccess()
    {
        return $this->emailSuccess;
    }

    /**
     *
     * @param string $emailSuccess
     */
    public function setEmailSuccess($emailSuccess)
    {
        $this->emailSuccess = $emailSuccess;
    }

    /**
     *
     * @return the $notificationFailure
     */
    public function getNotificationFailure()
    {
        return $this->notificationFailure;
    }

    /**
     *
     * @param boolean $notificationFailure
     */
    public function setNotificationFailure($notificationFailure)
    {
        $this->notificationFailure = $notificationFailure;
    }

    /**
     *
     * @return the $emailFailure
     */
    public function getEmailFailure()
    {
        return $this->emailFailure;
    }

    /**
     *
     * @param string $emailFailure
     */
    public function setEmailFailure($emailFailure)
    {
        $this->emailFailure = $emailFailure;
    }

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
