<?php
namespace DbSystel\DataObject;

/**
 * Class ServiceInvoice
 *
 * @package DbSystel\DataObject
 */
class ServiceInvoice extends AbstractDataObject
{

    /**
     *
     * @var string
     */
    private $number;

    /**
     *
     * @var string
     */
    private $description;

    /**
     *
     * @var Application
     */
    private $application;

    /**
     *
     * @var Environment
     */
    private $environment;

    /**
     *
     * @param string $number
     * @return ServiceInvoice
     */
    public function setNumber($number)
    {
        $this->number = $number;

        return $this;
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
     * @return ServiceInvoice
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
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
     * @return ServiceInvoice
     */
    public function setApplication(Application $application)
    {
        $this->application = $application;

        return $this;
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
     * @return ServiceInvoice
     */
    public function setEnvironment(Environment $environment)
    {
        $this->environment = $environment;

        return $this;
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