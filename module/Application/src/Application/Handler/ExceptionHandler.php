<?php
namespace Application\Handler;

use Zend\Mvc\MvcEvent;
use Zend\Log\LoggerInterface;

class ExceptionHandler
{

    /**
     * @var array
     */
    protected $config;

    /**
     * @var LoggerInterface
     */
    protected $logger;

    public function __construct(array $config, LoggerInterface $logger)
    {
        $this->config = $config;
        $this->logger = $logger;
    }

    public function handle(MvcEvent $event)
    {
        $randomChars = md5(uniqid('', true));
        $errorReference = substr($randomChars, strlen($randomChars) / 5, 7);
        $requestUri = $event->getRequest()->getRequestUri();
        $extra = [
            'error-reference' => $errorReference,
            'request-uri' => $requestUri
        ];
        // error log
        if ($event->getParam('exception')) {
            $this->logger->crit($event->getParam('exception'), $extra);
        }
        // @todo Make it dynamic! Since not every user should be able to see the technical error message.
        $userIsAdmin = true;
        // error page
        $event->getViewModel()
            ->setVariables(
            [
                'userIsAdmin' => $userIsAdmin,
                'errorReference' => $errorReference
            ]);
    }

}
