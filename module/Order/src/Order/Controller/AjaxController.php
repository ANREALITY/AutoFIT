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
        EnvironmentServiceInterface $environmentService,
        ServiceInvoicePositionServiceInterface $serviceInvoicePositionService, ServerServiceInterface $serverService)
    {
        $this->applicationService = $applicationService;
        $this->environmentService = $applicationService;
        $this->serverService = $applicationService;
        $this->serviceInvoicePositionService = $applicationService;
    }

    public function provideApplicationsAction()
    {
        $request = $this->getRequest();
        $dataList = [];

        if (true || $request->isXmlHttpRequest()) {
            $data = $request->getQuery('data');
            if (isset($data['technical_short_name']) && $data['technical_short_name'] != null) {
                $dataList = $this->applicationService->findAllByTechnicalShortName($data['technical_short_name']);
            }
        }

        return new JsonModel($dataList);
    }

    public function provideEnvironmentsAction()
    {
        $request = $this->getRequest();
        $dataList = [];

        if (true || $request->isXmlHttpRequest()) {
            $data = $request->getQuery('data');
            if (isset($data['name']) && $data['name'] != null) {
                $dataList = $this->environmentService->findAllByName($data['name']);
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
                $dataList = $this->serverService->findAllByName($data['name']);
            }
        }

        return new JsonModel($dataList);
    }

    public function provideServiceInvoicePositionsAction()
    {
        $request = $this->getRequest();
        $dataList = [];

        if (true || $request->isXmlHttpRequest()) {
            $data = $request->getQuery('data');
            if (isset($data['number']) && $data['number'] != null) {
                $dataList = $this->serviceInvoicePositionService->findAllByNumber($data['number']);
            }
        }

        return new JsonModel($dataList);
    }
}

