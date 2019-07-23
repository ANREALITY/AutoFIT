<?php
namespace Order\Service;

use Base\DataObject\Application;

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

    /**
     *
     * @param string $technicalShortName
     */
    public function findAllInUseForAutocomplete(string $technicalShortName);

}
