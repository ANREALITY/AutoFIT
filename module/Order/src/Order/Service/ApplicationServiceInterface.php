<?php
namespace Order\Service;

use DbSystel\DataObject\Application;

interface ApplicationServiceInterface
{

    /**
     *
     * @return array|Application[]
     */
    public function findAll();

    /**
     *
     * @param int $id
     *            Identifier of the Application that should be returned
     * @return Application
     */
    public function findApplication($id);

    /**
     *
     * @param Application $application
     * @return Application
     */
    public function saveApplication(Application $applicationRequest);

    /**
     *
     * @param string $technicalShortName
     */
    public function findAllByTechnicalShortName(string $technicalShortName);
}
