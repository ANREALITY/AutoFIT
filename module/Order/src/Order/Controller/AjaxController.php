<?php
namespace Order\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\JsonModel;
use Order\Service\ApplicationServiceInterface;
use Order\Service\EnvironmentServiceInterface;
use Order\Service\ServerServiceInterface;
use Order\Service\ServiceInvoicePositionServiceInterface;

class AjaxController extends AbstractActionController
{

    /**
     *
     * @var ApplicationServiceInterface
     */
    protected $applicationService = null;

    /**
     *
     * @var EnvironmentServiceInterface
     */
    protected $environmentService = null;

    /**
     *
     * @var ServerServiceInterface
     */
    protected $serverService = null;

    /**
     *
     * @var ServiceInvoicePositionServiceInterface
     */
    protected $serviceInvoicePositionService = null;

    public function __construct(ApplicationServiceInterface $applicationService,
        EnvironmentServiceInterface $environmentService, ServerServiceInterface $serverService,
        ServiceInvoicePositionServiceInterface $serviceInvoicePositionService)
    {
        $this->applicationService = $applicationService;
        $this->environmentService = $environmentService;
        $this->serverService = $serverService;
        $this->serviceInvoicePositionService = $serviceInvoicePositionService;
    }

    public function provideApplicationsAction()
    {
        $request = $this->getRequest();
        $dataList = [];

        if (true || $request->isXmlHttpRequest()) {
            $data = $request->getQuery('data');
            if (isset($data['technical_short_name']) && $data['technical_short_name'] != null) {
                $dataList = $this->applicationService->findAllByTechnicalShortName($data['technical_short_name'])->toArray();
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
            if (isset($data['name']) && $data['name'] != null) {
                $dataList = $this->environmentService->findAllByName($data['name'])->toArray();
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
            if (isset($data['name']) && $data['name'] != null) {
                $dataList = $this->serverService->findAllByName($data['name'])->toArray();
            }
        }

        return new JsonModel($dataList);
    }

    public function provideServiceInvoicePositionsBasicAction()
    {
        $request = $this->getRequest();
        $dataList = [];

        if (true || $request->isXmlHttpRequest()) {
            $data = $request->getQuery('data');
            if (! empty($data['number']) && ! empty($data['application_technical_short_name'])) {
                $dataList = $this->serviceInvoicePositionService->findAllBasicByNumberAndApplication($data['number'],
                    $data['application_technical_short_name'])->toArray();
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
            if (! empty($data['number']) && ! empty($data['application_technical_short_name'])) {
                $dataList = $this->serviceInvoicePositionService->findAllPersonalByNumberAndApplication($data['number'],
                    $data['application_technical_short_name'])->toArray();
            }
        }

        $dataList = array_column($dataList, 'number');

        return new JsonModel($dataList);
    }

}
