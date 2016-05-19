<?php
namespace ErrorHandling\Handler;

use Zend\Mvc\MvcEvent;
use Zend\Log\LoggerInterface;
use Zend\Mvc\I18n\Translator;
use Zend\Http\Request as HttpRequest;

class WarningHandler
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
     * @var Translator
     */
    protected $translator;

    public function __construct(array $config, LoggerInterface $logger, Translator $translator)
    {
        $this->config = $config;
        $this->logger = $logger;
        $this->translator = $translator;
    }

    public function handle(int $errno, string $errstr, string $errfile = null, int $errline = 0, array $errcontext = [], MvcEvent $event)
    {
        $randomChars = md5(uniqid('', true));
        $errorReference = substr($randomChars, strlen($randomChars) / 5, 7);
        $request = $event->getRequest();
        $requestUri = $request instanceof HttpRequest ? $request->getUri()->toString() : 'undefined';
        $exception = new \ErrorException(
            $errstr, $errno, 0, $errfile, $errline
        );
        // error log
        $event->setParam('exception', $exception);
        $extra = [
            'error-reference' => $errorReference,
            'request-uri' => $requestUri
        ];
        $this->logger->warn($event->getParam('exception'), $extra);
        return false;
    }

}
