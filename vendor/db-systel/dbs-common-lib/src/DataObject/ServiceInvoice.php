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
     * @return string $number
     */
    public function getNumber()
    {
        return $this->number;
    }

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
     * @return string $description
     */
    public function getDescription()
    {
        return $this->description;
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
     * @return Application $application
     */
    public function getApplication()
    {
        return $this->application;
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
     * @return Environment $environment
     */
    public function getEnvironment()
    {
        return $this->environment;
    }

    /**
     *
     * @param Environment $environment
     */
    public function setEnvironment(Environment $environment)
    {
        $this->environment = $environment;
    }

}