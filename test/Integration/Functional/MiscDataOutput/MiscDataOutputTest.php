<?php
namespace Test\Integration\Functional\MiscDataOutput;

use DbSystel\Test\AbstractControllerTest;
use Zend\Http\PhpEnvironment\Response;
use Zend\View\Model\JsonModel;

class MiscDataOutputTest extends AbstractControllerTest
{

    public function testGetApplications()
    {
        $technicalShortName = 'comga';
        $getApplicationsUrl = '/order/ajax/provide-applications?'
            . 'data[technical_short_name]=' . $technicalShortName
        ;
        $this->dispatch($getApplicationsUrl, null, [], true);

        $this->assertResponseStatusCode(Response::STATUS_CODE_200);
        $this->assertModuleName('Order');
        $this->assertControllerName('Order\Controller\Ajax');
        $this->assertControllerClass('AjaxController');
        $this->assertMatchedRouteName('provide-applications');

        /** @var JsonModel $jsonModel */
        $jsonModel = $this->getApplication()->getMvcEvent()->getResult();
        $actualResultsList = $jsonModel->getVariables();
        $expectedResultsList = [
            0 => 'comgate'
        ];
        $this->assertEquals($expectedResultsList, $actualResultsList);
    }

    public function testGetEnvironments()
    {
        $applicationTechnicalShortName = 'comgate';
        $name = 'ent';
        $getApplicationsUrl = '/order/ajax/provide-environments?'
            . 'data[application_technical_short_name]=' . $applicationTechnicalShortName
            . '&' . 'data[name]=' . $name
        ;
        $this->dispatch($getApplicationsUrl, null, [], true);

        $this->assertResponseStatusCode(Response::STATUS_CODE_200);
        $this->assertModuleName('Order');
        $this->assertControllerName('Order\Controller\Ajax');
        $this->assertControllerClass('AjaxController');
        $this->assertMatchedRouteName('provide-environments');

        /** @var JsonModel $jsonModel */
        $jsonModel = $this->getApplication()->getMvcEvent()->getResult();
        $actualResultsList = $jsonModel->getVariables();
        $expectedResultsList = [
            0 => [
                'severity' => 5,
                'name' => 'Entwicklung',
                'short_name' => 'E'
            ]
        ];
        $this->assertEquals($expectedResultsList, $actualResultsList);
    }

    protected function tearDown()
    {
        parent::tearDown();
        $reflectionObject = new \ReflectionObject($this);
        foreach ($reflectionObject->getProperties() as $prop) {
            if (!$prop->isStatic() && 0 !== strpos($prop->getDeclaringClass()->getName(), 'PHPUnit_')) {
                $prop->setAccessible(true);
                $prop->setValue($this, null);
            }
        }
        unset($_SERVER['AUTH_USER']);
    }

}
