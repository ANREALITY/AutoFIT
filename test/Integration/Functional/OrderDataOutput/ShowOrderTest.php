<?php
namespace Test\Integration\Functional\OrderDataOutput;

use Base\DataObject\EndpointCdLinuxUnix;
use Base\DataObject\FileTransferRequest;
use Base\DataObject\User;
use Exception;
use Order\Service\UserService;
use Zend\Http\PhpEnvironment\Response;

class ShowOrderTest extends AbstractOrderOutputTest
{

    /**
     * @param string $username
     * @param int $responseStatusCode
     * @throws Exception
     * @dataProvider provideDataForShowOrderAccess
     */
    public function testShowOrderAccess(string $username, int $responseStatusCode)
    {
        $connectionType = 'cd';
        $endpointSourceType = 'cdlinuxunix';
        $this->createOrder($connectionType, $endpointSourceType);

        $this->reset();

        $_SERVER['AUTH_USER'] = $username;

        $orderId = 1;
        $showUrl = '/order/show/' . $orderId;
        $this->dispatch($showUrl);
        $this->assertResponseStatusCode($responseStatusCode);
    }

    /**
     * @dataProvider provideDataForShowOrder
     * @param string $username
     * @param bool $isOwner
     * @throws Exception
     */
    public function testShowOrder(string $username, bool $isOwner)
    {
        $connectionType = 'cd';
        $endpointSourceType = 'cdlinuxunix';
        $createParams = $this->getCreateParams($connectionType, $endpointSourceType);
        $this->createOrder($connectionType, $endpointSourceType);

        $this->reset();

        $_SERVER['AUTH_USER'] = $username;

        // testing the access by the owner
        $orderId = 1;
        $showUrl = '/order/show/' . $orderId;
        $this->dispatch($showUrl);

        if ($isOwner) {
            $this->assertResponseStatusCode(Response::STATUS_CODE_200);
            $this->assertModuleName('Order');
            $this->assertControllerName('Order\Controller\Process');
            $this->assertControllerClass('ProcessController');
            $this->assertMatchedRouteName('order/show');

            /** @var FileTransferRequest $fileTransferRequest */
            $fileTransferRequest = $this->getApplication()->getMvcEvent()->getResult()->getVariable('fileTransferRequest', null);

            $fileTransferRequestData = $createParams['file_transfer_request'];
            $logicalConnectionData = $fileTransferRequestData['logical_connection'];
            $logicalConnection = $fileTransferRequest->getLogicalConnection();
            $physicalConnectionEndToEndData = $logicalConnectionData['physical_connection_end_to_end'];
            $physicalConnectionEndToEnd = $logicalConnection->getPhysicalConnectionEndToEnd();
            $endpointSourceData = $physicalConnectionEndToEndData['endpoint_source'];
            /** @var EndpointCdLinuxUnix $endpointSource */
            $endpointSource = $physicalConnectionEndToEnd->getEndpointSource();

            $this->assertNotNull($fileTransferRequest);
            $this->assertInstanceOf(FileTransferRequest::class, $fileTransferRequest);
            $this->assertEquals($orderId, $fileTransferRequest->getId());
            $this->assertEquals($fileTransferRequestData['change_number'], $fileTransferRequest->getChangeNumber());
            $this->assertEquals(
                $logicalConnectionData['notifications'][0]['email'],
                $logicalConnection->getNotifications()[0]->getEmail()
            );
            $this->assertEquals(
                $fileTransferRequestData['service_invoice_position_basic']['number'],
                $fileTransferRequest->getServiceInvoicePositionBasic()->getNumber()
            );
            $this->assertEquals(
                $fileTransferRequestData['service_invoice_position_personal']['number'],
                $fileTransferRequest->getServiceInvoicePositionPersonal()->getNumber()
            );
            $this->assertEquals(
                $endpointSourceData['endpoint_server_config']['server']['name'],
                $endpointSource->getEndpointServerConfig()->getServer()->getName()
            );
            $this->assertEquals(
                $endpointSourceData['include_parameter_set']['include_parameters'][0]['expression'],
                $endpointSource->getIncludeParameterSet()->getIncludeParameters()[0]->getExpression()
            );
        } else {
            $this->assertResponseStatusCode(Response::STATUS_CODE_302);
        }
    }

    /**
     * @dataProvider provideDataForHandlingNotExistentOrderId
     * @param string $username
     * @param bool $isAdmin
     * @throws Exception
     */
    public function testHandlingNotExistentOrderId(string $username, bool $isAdmin)
    {
        $connectionType = 'cd';
        $endpointSourceType = 'cdlinuxunix';
        $this->createOrder($connectionType, $endpointSourceType);

        $this->reset();

        $_SERVER['AUTH_USER'] = $username;

        // testing the access by the owner
        $orderId = 2;
        $showUrl = '/order/show/' . $orderId;
        $this->dispatch($showUrl);

        if ($isAdmin) {
            $this->assertResponseStatusCode(Response::STATUS_CODE_404);
            $this->assertModuleName('Order');
            $this->assertControllerName('Order\Controller\Process');
            $this->assertControllerClass('ProcessController');
            $this->assertMatchedRouteName('order/show');
        } else {
            $this->assertResponseStatusCode(Response::STATUS_CODE_302);
        }
    }

    public function provideDataForShowOrderAccess()
    {
        return [
            // owner
            'owner' => [
                'username' => UserService::DEFAULT_MEMBER_USERNAME,
                'responseStatusCode' => Response::STATUS_CODE_200,
            ],
            // non-owner guest
            'guest' => [
                'username' => UserService::DEFAULT_GUEST_USERNAME,
                'responseStatusCode' => Response::STATUS_CODE_302,
            ],
            // non-owner member
            'member' => [
                'username' => 'foo', // another member
                'responseStatusCode' => Response::STATUS_CODE_302,
            ],
            // non-owner power user
            'power-user' => [
                'username' => UserService::DEFAULT_POWER_USER_USERNAME,
                'responseStatusCode' => Response::STATUS_CODE_200,
            ],
            // non-owner admin
            'admin' => [
                'username' => UserService::DEFAULT_ADMIN_USERNAME,
                'responseStatusCode' => Response::STATUS_CODE_200,
            ],
        ];
    }

    public function provideDataForShowOrder()
    {
        return [
            'owner' => [
                'username' => UserService::DEFAULT_MEMBER_USERNAME,
                'isOwner' => true,
            ],
            'nonOwner' => [
                'username' => 'foo',
                'isOwner' => false,
            ],
        ];
    }

    public function provideDataForHandlingNotExistentOrderId()
    {
        return [
            'admin' => [
                'username' => UserService::DEFAULT_ADMIN_USERNAME,
                'isAdmin' => true,
            ],
            'nonAdmin' => [
                'username' => UserService::DEFAULT_MEMBER_USERNAME,
                'isAdmin' => false,
            ],
        ];
    }

}
