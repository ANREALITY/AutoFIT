<?php
namespace Test\Integration\Functional\OrderDataOutput;

use DbSystel\DataObject\AbstractEndpoint;
use DbSystel\DataObject\FileTransferRequest;
use DbSystel\DataObject\LogicalConnection;
use DbSystel\Paginator\Paginator;
use Zend\Http\PhpEnvironment\Response;

class ListOrdersTest extends AbstractOrderOutputTest
{

    /**
     * @var int
     */
    const ITEMS_PER_PAGE = 3;

    public function testListMyOrders()
    {
        $this->createOrders();

        $this->reset();

        $username = 'foo';
        $_SERVER['AUTH_USER'] = $username;

        $listUrl = '/list-my-orders';
        $this->dispatch($listUrl);
        $this->assertResponseStatusCode(Response::STATUS_CODE_200);
        $this->assertModuleName('Order');
        $this->assertControllerName('Order\Controller\Process');
        $this->assertControllerClass('ProcessController');
        $this->assertMatchedRouteName('list-my-orders');

        /** @var Paginator $paginator */
        $paginator = $this->getApplication()->getMvcEvent()->getResult()->getVariable('paginator', null);

        $this->assertNotNull($paginator);
        $this->assertInstanceOf(Paginator::class, $paginator);

        $this->assertEquals(self::ITEMS_PER_PAGE, $paginator->getCurrentItemCount());
        $this->assertEquals(
            $this->getOrdersCountForUser('foo'),
            $paginator->getTotalItemCount()
        );
        /** @var FileTransferRequest[] $currentItems */
        $currentItems = $paginator->getCurrentItems();
        foreach ($currentItems as $currentItem) {
            $this->assertInstanceOf(FileTransferRequest::class, $currentItem);
        }
        $createParamsForCdAs400 = $this->getCreateParams(
            strtolower(LogicalConnection::TYPE_CD),
            strtolower(AbstractEndpoint::TYPE_CD_AS400)
        );
        $this->assertEquals(
            $createParamsForCdAs400['file_transfer_request']['change_number'],
            $currentItems[0]->getChangeNumber()
        );
    }

    public function testListOrders()
    {
        $this->createOrders();

        $this->reset();

        $username = 'foo';
        $_SERVER['AUTH_USER'] = $username;

        $listUrl = '/list-orders';
        $this->dispatch($listUrl);
        $this->assertResponseStatusCode(Response::STATUS_CODE_200);
        $this->assertModuleName('Order');
        $this->assertControllerName('Order\Controller\Process');
        $this->assertControllerClass('ProcessController');
        $this->assertMatchedRouteName('list-orders');

        /** @var Paginator $paginator */
        $paginator = $this->getApplication()->getMvcEvent()->getResult()->getVariable('paginator', null);

        $this->assertNotNull($paginator);
        $this->assertInstanceOf(Paginator::class, $paginator);

        $this->assertEquals(self::ITEMS_PER_PAGE, $paginator->getCurrentItemCount());
        $this->assertEquals(
            $this->getOrdersCountForUser('foo') + $this->getOrdersCountForUser('bar'),
            $paginator->getTotalItemCount()
        );
        /** @var FileTransferRequest[] $currentItems */
        $currentItems = $paginator->getCurrentItems();
        foreach ($currentItems as $currentItem) {
            $this->assertInstanceOf(FileTransferRequest::class, $currentItem);
        }
        $createParamsForCdAs400 = $this->getCreateParams(
            strtolower(LogicalConnection::TYPE_CD),
            strtolower(AbstractEndpoint::TYPE_CD_AS400)
        );
        $this->assertEquals(
            $createParamsForCdAs400['file_transfer_request']['change_number'],
            $currentItems[0]->getChangeNumber()
        );
    }

    public function testListOrdersPagination()
    {
        $this->createOrders();

        $this->reset();

        $username = 'foo';
        $_SERVER['AUTH_USER'] = $username;

        $listUrl = '/list-orders/page/2';
        $this->dispatch($listUrl);
        $this->assertResponseStatusCode(Response::STATUS_CODE_200);
        $this->assertModuleName('Order');
        $this->assertControllerName('Order\Controller\Process');
        $this->assertControllerClass('ProcessController');
        $this->assertMatchedRouteName('list-orders');

        /** @var Paginator $paginator */
        $paginator = $this->getApplication()->getMvcEvent()->getResult()->getVariable('paginator', null);

        $this->assertNotNull($paginator);
        $this->assertInstanceOf(Paginator::class, $paginator);

        $this->assertEquals(self::ITEMS_PER_PAGE, $paginator->getCurrentItemCount());
        $this->assertEquals(
            $this->getOrdersCountForUser('foo') + $this->getOrdersCountForUser('bar'),
            $paginator->getTotalItemCount()
        );
        /** @var FileTransferRequest[] $currentItems */
        $currentItems = $paginator->getCurrentItems();
        foreach ($currentItems as $currentItem) {
            $this->assertInstanceOf(FileTransferRequest::class, $currentItem);
        }
        $createParamsForFtgwCdWindows = $this->getCreateParams(
            strtolower(LogicalConnection::TYPE_FTGW),
            strtolower(AbstractEndpoint::TYPE_FTGW_CD_AS400)
        );
        $this->assertEquals(
            $createParamsForFtgwCdWindows['file_transfer_request']['change_number'],
            $currentItems[0]->getChangeNumber()
        );
    }

    protected function createOrders()
    {
        foreach ($this->getOrderTypes() as $username => $orderTypes) {
            $_SERVER['AUTH_USER'] = $username;
            foreach ($orderTypes as $connectionType => $endpointTypes) {
                foreach ($endpointTypes as $endpointType) {
                    parent::createOrder($connectionType, $endpointType, null);
                }
            }
        }

        unset($_SERVER['AUTH_USER']);
    }

    protected function getOrderTypes(string $username = null)
    {
        $orderTypes = [];
        $orderUsersToTypes = [
            'foo' => [
                LogicalConnection::TYPE_CD => [
                    'cdas400',
                    'cdlinuxunix',
                    'cdtandem',
                ],
                LogicalConnection::TYPE_FTGW => [
                    'ftgwcdas400',
                    'ftgwcdtandem',
                    'ftgwcdzos',
                    'ftgwlinuxunix',
                ],
            ],
            'bar' => [
                LogicalConnection::TYPE_CD => [
                    'cdwindows',
                    'cdwindowsshare',
                    'cdzos',
                ],
                LogicalConnection::TYPE_FTGW => [
                    'ftgwprotocolserver',
                    'ftgwselfservice',
                    'ftgwwindows',
                    'ftgwwindowsshare',
                ],
            ],
        ];
        if (! $username) {
            $orderTypes = $orderUsersToTypes;
        } else {
            $orderTypes = isset($orderUsersToTypes[$username]) ? $orderUsersToTypes[$username] : [];
        }
        return $orderTypes;
    }

    protected function getOrdersCountForUser(string $username)
    {
        $orderTypes = $this->getOrderTypes($username);
        return count($orderTypes[LogicalConnection::TYPE_CD]) + count($orderTypes[LogicalConnection::TYPE_FTGW]);
    }

    protected function setConfigItemsPerPage()
    {
        $config = $this->getApplicationServiceLocator()->get('config');
        $this->getApplicationServiceLocator()->setAllowOverride(true);
        $config['module']['order']['pagination']['items_per_page'] = self::ITEMS_PER_PAGE;
        $this->getApplicationServiceLocator()->setService('config', $config);
        $this->getApplicationServiceLocator()->setAllowOverride(false);
    }

}
