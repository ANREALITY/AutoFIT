<?php
namespace Test\Integration\Functional\OrderDataOutput;

use Base\DataObject\FileTransferRequest;
use Base\DataObject\LogicalConnection;
use Base\DataObject\User;
use Base\Paginator\Paginator;
use Zend\Http\PhpEnvironment\Response;

class ListOrdersTest extends AbstractOrderOutputTest
{

    /**
     * @var int
     */
    const ITEMS_PER_PAGE = 3;

    public function testListOrders()
    {
        $this->createOrders();

        $this->reset();

        $username = 'foo';
        $_SERVER['AUTH_USER'] = $username;

        $listUrl = '/order/list';
        $this->dispatch($listUrl);
        $this->assertResponseStatusCode(Response::STATUS_CODE_200);
        $this->assertModuleName('Order');
        $this->assertControllerName('Order\Controller\Process');
        $this->assertControllerClass('ProcessController');
        $this->assertMatchedRouteName('order/list');

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
        /** @var FileTransferRequest $latestOrder */
        $latestOrder = $this->entityManager->getRepository(FileTransferRequest::class)
            ->findOneBy([], ['created' => 'DESC'])
        ;
        $this->assertEquals(
            $latestOrder->getChangeNumber(),
            $currentItems[0]->getChangeNumber()
        );
    }

    public function testListOrdersPagination()
    {
        $this->createOrders();

        $this->reset();

        $username = 'foo';
        $_SERVER['AUTH_USER'] = $username;

        $listUrl = '/order/list/page/2';
        $this->dispatch($listUrl);
        $this->assertResponseStatusCode(Response::STATUS_CODE_200);
        $this->assertModuleName('Order');
        $this->assertControllerName('Order\Controller\Process');
        $this->assertControllerClass('ProcessController');
        $this->assertMatchedRouteName('order/list');

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
        /** @var FileTransferRequest[] $latestOrders */
        $latestOrders = $this->entityManager->getRepository(FileTransferRequest::class)
            ->findBy(
                [], ['created' => 'DESC']
            )
        ;
        // second page and then "-1" for the array index
        $neededOrderIndex = ($paginator->getItemCountPerPage() + 1) - 1;
        $this->assertEquals(
            $latestOrders[$neededOrderIndex]->getChangeNumber(),
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
                    /*
                     * Otherwise it was not possible to guarantee the comparing of orders for tests.
                     * @todo This solution makes the tests much slowlier ans should be reviewed.
                     */
                    sleep(1);
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
