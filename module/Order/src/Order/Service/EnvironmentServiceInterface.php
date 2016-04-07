<?php
namespace Order\Service;

use DbSystel\DataObject\Environment;

interface EnvironmentServiceInterface
{

    /**
     *
     * @return array|Environment[]
     */
    public function findAll();

    /**
     *
     * @param int $id
     *            Identifier of the Environment that should be returned
     * @return Environment
     */
    public function findEnvironment($id);

    /**
     *
     * @param Environment $environment
     * @return Environment
     */
    public function saveEnvironment(Environment $environmentRequest);

    /**
     *
     * @param string $applicationTechnicalShortName
     * @param string $name
     */
    public function findAllByApplicationAndName(string $applicationTechnicalShortName, string $name = null);

}
