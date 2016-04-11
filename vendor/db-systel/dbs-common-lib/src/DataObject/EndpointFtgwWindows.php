<?php
namespace DbSystel\DataObject;

class EndpointFtgwWindows extends AbstractEndpoint
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

}
