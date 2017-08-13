<?php
namespace Test\Integration\Functional\MasterDataManipulation;

use MasterData\Form\ServerForm;
use Zend\Http\PhpEnvironment\Response;
use Zend\Http\Request;

class ServerMasterDataManipulationTest extends AbstractMasterDataManipulationTest
{

    public function testInputNoneOutputForm()
    {
        $editServerUrl = '/master-data/server/edit';
        $this->dispatch($editServerUrl);
        $this->assertResponseStatusCode(Response::STATUS_CODE_200);
        $this->assertModuleName('MasterData');
        $this->assertControllerName('MasterData\Controller\Server');
        $this->assertControllerClass('ServerController');
        $this->assertMatchedRouteName('master-data/edit-server');

        /** @var ServerForm $serverForm */
        $serverForm = $this->getApplication()->getMvcEvent()->getResult()->getVariable('form', null);

        $this->assertNotNull($serverForm);
        $this->assertInstanceOf(ServerForm::class, $serverForm);
    }

    public function testInputDataActionSaving()
    {
        $formParams = $this->getFormParams(self::FORM_EDIT_SERVER);

        $editServerUrl = '/master-data/server/edit';
        $this->dispatch($editServerUrl, Request::METHOD_POST, $formParams);

        $this->assertEquals(
            $formParams['server']['virtual_node_name'],
            $this->retrieveActualData('server', 'name', 'epa3')['virtual_node_name']
        );
    }

}
