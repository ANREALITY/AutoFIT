<?php
namespace Order\Controller;

use Order\Service\FileTransferRequestServiceInterface;
use Order\Service\UserServiceInterface;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\JsonModel;
use Order\Service\ApplicationServiceInterface;
use Order\Service\EnvironmentServiceInterface;
use Order\Service\ServerServiceInterface;
use Order\Service\ServiceInvoicePositionServiceInterface;
use Order\Service\ClusterServiceInterface;

class AjaxController extends AbstractActionController
{

    /**
     *
     * @var ApplicationServiceInterface
     */
    protected $applicationService;

    /**
     *
     * @var EnvironmentServiceInterface
     */
    protected $environmentService;

    /**
     *
     * @var ServerServiceInterface
     */
    protected $serverService;

    /**
     *
     * @var ServiceInvoicePositionServiceInterface
     */
    protected $serviceInvoicePositionService;

    /**
     *
     * @var ClusterServiceInterface
     */
    protected $clusterService;

    /**
     *
     * @var UserServiceInterface
     */
    protected $userService;

    /**
     *
     * @var FileTransferRequestServiceInterface
     */
    protected $fileTransferRequestService;

    public function __construct(
        ApplicationServiceInterface $applicationService,
        EnvironmentServiceInterface $environmentService,
        ServerServiceInterface $serverService,
        ServiceInvoicePositionServiceInterface $serviceInvoicePositionService,
        ClusterServiceInterface $clusterService,
        UserServiceInterface $userService,
        FileTransferRequestServiceInterface $fileTransferRequestService
        ) {
        $this->applicationService = $applicationService;
        $this->environmentService = $environmentService;
        $this->serverService = $serverService;
        $this->serviceInvoicePositionService = $serviceInvoicePositionService;
        $this->clusterService = $clusterService;
        $this->userService = $userService;
        $this->fileTransferRequestService = $fileTransferRequestService;
    }

    public function provideApplicationsAction()
    {
        $request = $this->getRequest();
        $dataList = ['error' => 'Acces only for AJAX requests!'];

        if ($request->isXmlHttpRequest()) {
            $data = $request->getQuery('data');
            if (isset($data['technical_short_name']) && $data['technical_short_name'] != null) {
                $dataList = $this->applicationService->findAllForAutocomplete($data['technical_short_name']);
                $dataList = array_column($dataList, 'technicalShortName');
            } else {
                $dataList = [];
            }
        }

        return new JsonModel($dataList);
    }

    public function provideEnvironmentsAction()
    {
        $request = $this->getRequest();
        $dataList = ['error' => 'Acces only for AJAX requests!'];

        if ($request->isXmlHttpRequest()) {
            $data = $request->getQuery('data');
            if (! empty($data['application_technical_short_name'])) {
                $data['name'] = isset($data['name']) ? $data['name'] : null;
                $dataList = $this->environmentService->findAllForAutocomplete(
                    $data['application_technical_short_name'], $data['name']
                );
            } else {
                $dataList = [];
            }
        }

        return new JsonModel($dataList);
    }

    public function provideServersAction()
    {
        $request = $this->getRequest();
        $dataList = ['error' => 'Acces only for AJAX requests!'];

        if ($request->isXmlHttpRequest()) {
            $data = $request->getQuery('data');
            $data['endpoint_type_name'] = isset($data['endpoint_type_name']) ? $data['endpoint_type_name'] : null;
            $dataList = $this->serverService->findAllForAutocomplete($data['name'], $data['endpoint_type_name']);
            $dataList = array_column($dataList, 'name');
        }

        return new JsonModel($dataList);
    }

    public function provideServersNotInCdUseAction()
    {
        $request = $this->getRequest();
        $dataList = ['error' => 'Acces only for AJAX requests!'];

        if ($request->isXmlHttpRequest()) {
            $data = $request->getQuery('data');
            $dataList = $this->serverService->findAllNotInCdUseForAutocomplete($data['name']);
            $dataList = array_column($dataList, 'name');
        }

        return new JsonModel($dataList);
    }

    public function provideServersNotInClusterAction()
    {
        $request = $this->getRequest();
        $dataList = ['error' => 'Acces only for AJAX requests!'];

        if ($request->isXmlHttpRequest()) {
            $data = $request->getQuery('data');
            $dataList = $this->serverService->findAllNotInClusterForAutocomplete($data['name']);
            $dataList = array_column($dataList, 'name');
        }

        return new JsonModel($dataList);
    }

    public function provideServiceInvoicePositionsBasicAction()
    {
        $request = $this->getRequest();
        $dataList = ['error' => 'Acces only for AJAX requests!'];

        if ($request->isXmlHttpRequest()) {
            $data = $request->getQuery('data');
            if (! empty($data['application_technical_short_name']) && ! empty($data['environment_severity'])) {
                $dataList = $this->serviceInvoicePositionService->findAllBasicForAutocomplete(
                    $data['number'],
                    $data['application_technical_short_name'],
                    $data['environment_severity'],
                    $data['connection_type']
                );
                $dataList = array_column($dataList, 'number');
            } else {
                $dataList = [];
            }
        }

        return new JsonModel($dataList);
    }

    public function provideServiceInvoicePositionsPersonalAction()
    {
        $request = $this->getRequest();
        $dataList = ['error' => 'Acces only for AJAX requests!'];

        if ($request->isXmlHttpRequest()) {
            $data = $request->getQuery('data');
            if (! empty($data['application_technical_short_name']) && ! empty($data['environment_severity'])) {
                $dataList = $this->serviceInvoicePositionService->findAllPersonalForAutocomplete(
                    $data['number'],
                    $data['application_technical_short_name'],
                    $data['environment_severity'],
                    $data['connection_type']
                );
                $dataList = array_column($dataList, 'number');
            } else {
                $dataList = [];
            }
        }

        return new JsonModel($dataList);
    }

    public function provideClustersAction()
    {
        $request = $this->getRequest();
        $dataList = ['error' => 'Acces only for AJAX requests!'];

        if ($request->isXmlHttpRequest()) {
            $data = $request->getQuery('data');
            $data['virtual_node_name'] = isset($data['virtual_node_name']) ? $data['virtual_node_name'] : null;
            $dataList = $this->clusterService->findAllForAutocomplete($data['virtual_node_name']);
        } else {
            $dataList = [];
        }

        return new JsonModel($dataList);
    }

    public function provideUsersAction()
    {
        $request = $this->getRequest();
        $dataList = ['error' => 'Acces only for AJAX requests!'];

        if ($request->isXmlHttpRequest()) {
            $data = $request->getQuery('data');
            $username = isset($data['username']) ? $data['username'] : null;

            $result = $this->userService->findAllForAutocomplete($username);
            $dataList = array_column($result, 'username');
        }

        return new JsonModel($dataList);
    }

    public function provideFileTransferRequestsAction()
    {
        $request = $this->getRequest();
        $dataList = ['error' => 'Acces only for AJAX requests!'];

        if ($request->isXmlHttpRequest()) {
            $data = $request->getQuery('data');
            $changeNumber = isset($data['change_number']) ? $data['change_number'] : null;

            $result = $this->fileTransferRequestService->findAllForAutocomplete($changeNumber);
            $dataList = array_column($result, 'changeNumber');
        }


        return new JsonModel($dataList);
    }

}
