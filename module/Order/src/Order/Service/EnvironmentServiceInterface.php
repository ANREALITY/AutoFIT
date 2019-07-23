<?php
namespace Order\Service;

use Base\DataObject\Environment;

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
    public function findAllForAutocomplete(string $applicationTechnicalShortName = null, string $name = null);

    /**
     *
     * @param Environment $environment
     * @return Environment
     */
    public function saveOne(Environment $environmentRequest);

}
