<?php
namespace Order\Controller;

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

    public function __construct(ApplicationServiceInterface $applicationService,
        EnvironmentServiceInterface $environmentService, ServerServiceInterface $serverService,
        ServiceInvoicePositionServiceInterface $serviceInvoicePositionService,
        ClusterServiceInterface $clusterService)
    {
        $this->applicationService = $applicationService;
        $this->environmentService = $environmentService;
        $this->serverService = $serverService;
        $this->serviceInvoicePositionService = $serviceInvoicePositionService;
        $this->clusterService = $clusterService;
    }

    public function provideApplicationsAction()
    {
        $request = $this->getRequest();
        $dataList = [];

        if (true || $request->isXmlHttpRequest()) {
            $data = $request->getQuery('data');
            if (isset($data['technical_short_name']) && $data['technical_short_name'] != null) {
                $dataList = $this->applicationService->findAllForAutocomplete($data['technical_short_name'])->toArray();
            }
        }

        $dataList = array_column($dataList, 'technical_short_name');

        return new JsonModel($dataList);
    }

    public function provideEnvironmentsAction()
    {
        $request = $this->getRequest();
        $dataList = [];

        if (true || $request->isXmlHttpRequest()) {
            $data = $request->getQuery('data');
            if (! empty($data['application_technical_short_name'])) {
                $data['name'] = isset($data['name']) ? $data['name'] : null;
                $dataList = $this->environmentService->findAllByApplicationAndName(
                    $data['application_technical_short_name'], $data['name'])->toArray();
            }
        }

        return new JsonModel($dataList);
    }

    public function provideServersAction()
    {
        $request = $this->getRequest();
        $dataList = [];

        if (true || $request->isXmlHttpRequest()) {
            $data = $request->getQuery('data');
            $data['endpoint_type_name'] = isset($data['endpoint_type_name']) ? $data['endpoint_type_name'] : null;
            $dataList = $this->serverService->findAllForAutocomplete($data['name'], $data['endpoint_type_name'])->toArray();
        }

        $dataList = array_column($dataList, 'name');

        return new JsonModel($dataList);
    }

    public function provideServiceInvoicePositionsBasicAction()
    {
        $request = $this->getRequest();
        $dataList = [];

        if (true || $request->isXmlHttpRequest()) {
            $data = $request->getQuery('data');
            if (! empty($data['application_technical_short_name']) && ! empty($data['environment_severity'])) {
                $dataList = $this->serviceInvoicePositionService->findAllBasicForAutocomplete(
                    $data['number'], $data['application_technical_short_name'], $data['environment_severity'])->toArray();
            }
        }

        $dataList = array_column($dataList, 'number');

        return new JsonModel($dataList);
    }

    public function provideServiceInvoicePositionsPersonalAction()
    {
        $request = $this->getRequest();
        $dataList = [];

        if (true || $request->isXmlHttpRequest()) {
            $data = $request->getQuery('data');
            if (! empty($data['application_technical_short_name']) && ! empty($data['environment_severity'])) {
                $dataList = $this->serviceInvoicePositionService->findAllPersonalForAutocomplete(
                    $data['number'], $data['application_technical_short_name'], $data['environment_severity'])->toArray();
            }
        }

        $dataList = array_column($dataList, 'number');

        return new JsonModel($dataList);
    }

    public function provideClustersAction()
    {
        $request = $this->getRequest();
        $dataList = [];

        if (true || $request->isXmlHttpRequest()) {
            $data = $request->getQuery('data');
                $data['virtual_node_name'] = isset($data['virtual_node_name']) ? $data['virtual_node_name'] : null;
                $dataList = $this->clusterService->findAllForAutocomplete($data['virtual_node_name'])->toArray();
        }

        return new JsonModel($dataList);
    }

}
