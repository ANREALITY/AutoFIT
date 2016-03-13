<?php
namespace Order\Service;

use DbSystel\DataObject\Application;

interface ApplicationServiceInterface
{

    /**
     *
     * @return array|Application[]
     */
    public function findAllApplications();

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
}
