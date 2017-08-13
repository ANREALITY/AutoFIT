<?php
namespace Test\Integration\Functional\MasterDataManipulation;

use DbSystel\Test\AbstractControllerTest;

abstract class AbstractMasterDataManipulationTest extends AbstractControllerTest
{

    /** @var string */
    const FORM_EDIT_SERVER = 'edit-server';
    /** @var string */
    const FORM_CREATE_CLUSTER = 'create-cluster';

    protected function getFormParams(string $formName)
    {
        $fixturesRootFolder = $this->getApplicationServiceLocator()->get('config')['fixtures']['folder'];
        $fixturesFolder = $fixturesRootFolder . '/' . 'master-data-form-data';
        $fixtureFile = $formName . '.json';
        $fixtureFilePath = $fixturesFolder . '/' . $fixtureFile;
        $fixtureJson = file_get_contents($fixtureFilePath);
        $formParams = json_decode($fixtureJson, true);
        return $formParams;
    }

}
