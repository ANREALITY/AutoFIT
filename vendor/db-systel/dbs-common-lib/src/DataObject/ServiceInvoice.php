<?php
namespace DbSystel\DataObject;

class ServiceInvoice extends AbstractDataObject
{

    /**
     *
     * @var string
     */
    protected $number;

    /**
     *
     * @var string
     */
    protected $description;

    /**
     *
     * @var Application
     */
    protected $application;

    /**
     *
     * @var Environment
     */
    protected $environment;

    /**
     *
     * @param string $number
     */
    public function setNumber($number)
    {
        $this->number = $number;
    }

    /**
     *
     * @return string $number
     */
    public function getNumber()
    {
        return $this->number;
    }

    /**
     *
     * @param string $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     *
     * @return string $description
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     *
     * @param Application $application
     */
    public function setApplication(Application $application)
    {
        $this->application = $application;
    }

    /**
     *
     * @return Application $application
     */
    public function getApplication()
    {
        return $this->application;
    }

    /**
     *
     * @param Environment $environment
     */
    public function setEnvironment(Environment $environment)
    {
        $this->environment = $environment;
    }

    /**
     *
     * @return Environment $environment
     */
    public function getEnvironment()
    {
        return $this->environment;
    }

}