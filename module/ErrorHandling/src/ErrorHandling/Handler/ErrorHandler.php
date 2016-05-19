<?php
namespace ErrorHandling\Handler;

use Zend\Mvc\MvcEvent;
use Zend\Log\LoggerInterface;
use Zend\Mvc\I18n\Translator;
use Zend\Http\Request as HttpRequest;

class ErrorHandler
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

    public function handle(\Throwable $exception, MvcEvent $event)
    {
        $randomChars = md5(uniqid('', true));
        $errorReference = substr($randomChars, strlen($randomChars) / 5, 7);
        $request = $event->getRequest();
        $requestUri = $request instanceof HttpRequest ? $request->getUri()->toString() : 'undefined';
        // error log
        $extra = [
            'error-reference' => $errorReference,
            'request-uri' => $requestUri
        ];
        $this->logger->crit($exception, $extra);
        // error page
        // @todo Make it dynamic! Since not every user should be able to see the technical error message.
        $userIsAdmin = true;
        $message = null;
        if ($userIsAdmin) {
            @trigger_error($exception);
            $lastErrorData = error_get_last();
            $message = <<<MESSAGE
TYPE: {$lastErrorData['type']}
MESSAGE: {$lastErrorData['message']}
FILE: {$lastErrorData['file']}
LINE: {$lastErrorData['line']}
MESSAGE;
        }
        ob_start();
        xdebug_var_dump(debug_backtrace());
        $debugBacktrace = ob_get_clean();
        $output = [
            // header
            $this->translator->translate('An error occured. Please try later again.'),
            // error reference
            sprintf($this->translator->translate('Error reference: %s.'), $errorReference),
            // error info
            $message,
            // debug backtrace
            $debugBacktrace
        ];
        $errorViewPath = $this->config['fatal_error_view'];
        $body = file_get_contents($errorViewPath);
        $body = str_replace(
            [
                '%__HEADER__%',
                '%__ERROR_REFERENCE__%',
                '%__ERROR_INFO__%',
                '%__DEBUG_BACKTRACE__%'
            ], $output, $body);
        echo $body;
        error_log($exception);
    }

}
