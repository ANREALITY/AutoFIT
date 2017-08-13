<?php
namespace Test\Integration\Functional\MasterDataManipulation;

use MasterData\Form\ClusterForm;
use Zend\Http\PhpEnvironment\Response;
use Zend\Http\Request;

class ClusterMasterDataManipulationTest extends AbstractMasterDataManipulationTest
{

    public function testInputNoneOutputForm()
    {
        $createClusterUrl = '/master-data/cluster/create';
        $this->dispatch($createClusterUrl);
        $this->assertResponseStatusCode(Response::STATUS_CODE_200);
        $this->assertModuleName('MasterData');
        $this->assertControllerName('MasterData\Controller\Cluster');
        $this->assertControllerClass('ClusterController');
        $this->assertMatchedRouteName('master-data/create-cluster');

        /** @var ClusterForm $clusterForm */
        $clusterForm = $this->getApplication()->getMvcEvent()->getResult()->getVariable('form', null);

        $this->assertNotNull($clusterForm);
        $this->assertInstanceOf(ClusterForm::class, $clusterForm);
    }

    public function testInputDataActionSaving()
    {
        $formParams = $this->getFormParams(self::FORM_CREATE_CLUSTER);

        $createClusterUrl = '/master-data/cluster/create';
        $this->dispatch($createClusterUrl, Request::METHOD_POST, $formParams);

        $this->assertEquals(
            $formParams['cluster']['virtual_node_name'],
            // The cluster with the ID=1 already existets (created with the basic data setup).
            $this->retrieveActualData('cluster', 'id', 2)['virtual_node_name']
        );
    }

}
