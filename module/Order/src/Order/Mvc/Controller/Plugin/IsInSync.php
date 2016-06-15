<?php
namespace Order\Mvc\Controller\Plugin;

use Zend\Mvc\Controller\Plugin\AbstractPlugin;
use Order\Service\SynchronizationService;

class IsInSync extends AbstractPlugin
{

    /**
     *
     * @var SynchronizationService
     */
    protected $synchronizationService;

    public function __construct(SynchronizationService $synchronizationService)
    {
        $this->synchronizationService = $synchronizationService;
    }

    public function __invoke()
    {
        $isInSync = false;
        $synchronizations = $this->synchronizationService->findAll();
        foreach ($synchronizations as $synchronization) {
            if ($synchronization->getInProgress()) {
                $isInSync = true;
                break;
            }
        }
        return $isInSync;
    }

}