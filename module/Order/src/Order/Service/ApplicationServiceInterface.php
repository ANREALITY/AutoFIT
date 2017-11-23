<?php
namespace Order\Service;

use DbSystel\DataObject\Application;

interface ApplicationServiceInterface
{

    /**
     *
     * @param int $id
     *            Identifier of the Application that should be returned
     * @return Application
     */
    public function findOne($id);

    /**
     *
     * @param string $technicalShortName
     */
    public function findAllForAutocomplete(string $technicalShortName);

}
