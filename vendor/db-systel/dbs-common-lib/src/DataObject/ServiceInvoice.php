<?php
namespace DbSystel\DataObject;

class ServiceInvoice
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
     * @return the $number
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
     * @return the $description
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
     * @return the $application
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
     * @return the $environment
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