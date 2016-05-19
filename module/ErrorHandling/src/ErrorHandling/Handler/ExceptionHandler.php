<?php
namespace ErrorHandling\Handler;

use Zend\Mvc\MvcEvent;
use Zend\Log\LoggerInterface;
use Zend\Http\Request as HttpRequest;
use Zend\Mvc\Application;

class ExceptionHandler
{

    /**
     *
     * @var array
     */
    protected $config;

    /**
     *
     * @var LoggerInterface
     */
    protected $logger;

    /**
     *
     * @var boolean
     */
    protected $showErrorDetails;

    public function __construct(array $config, LoggerInterface $logger, bool $showErrorDetails)
    {
        $this->config = $config;
        $this->logger = $logger;
        $this->showErrorDetails = $showErrorDetails;
    }

    public function handle(MvcEvent $event)
    {
        $randomChars = md5(uniqid('', true));
        $errorReference = substr($randomChars, strlen($randomChars) / 5, 7);
        $request = $event->getRequest();
        $requestUri = $request instanceof HttpRequest ? $request->getUri()->toString() : 'undefined';
        $extra = [
            'error-reference' => $errorReference,
            'request-uri' => $requestUri
        ];
        // error log
        $exception = $event->getParam('exception');
        if ($exception) {
            $this->logger->crit($exception, $extra);
        } elseif ($event->getParam('error') === Application::ERROR_ROUTER_NO_MATCH) {
            $this->logger->notice($exception, $extra);
        }
        // error page
        $event->getViewModel()->setVariables(
            [
                'showErrorDetails' => $this->showErrorDetails,
                'errorReference' => $errorReference
            ]);
        error_log($exception);
    }

}
