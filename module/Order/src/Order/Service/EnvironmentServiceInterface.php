<?php
namespace Order\Service;

use DbSystel\DataObject\Environment;

interface EnvironmentServiceInterface
{
    /**
     *
     * @param int $id
     *            Identifier of the Environment that should be returned
     * @return Environment
     */
    public function findOne($id);
    /**
     *
     * @param string $applicationTechnicalShortName
     * @param string $name
     */
    public function findAllByApplicationAndName(string $applicationTechnicalShortName, string $name = null);

    /**
     *
     * @param Environment $environment
     * @return Environment
     */
    public function saveOne(Environment $environmentRequest);


}
