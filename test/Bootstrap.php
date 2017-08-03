<?php
namespace Test;

use DbSystel\Test\AbstractIntegrationTest;
use DbSystel\Test\DatabaseInitializer;
use RuntimeException;
use Zend\Loader\AutoloaderFactory;
use Zend\Mvc\Service\ServiceManagerConfig;
use Zend\ServiceManager\ServiceManager;

error_reporting(E_ALL | E_STRICT);
chdir(__DIR__);

/**
 * Sets up the MVC (application, service manager, autoloading) and the database.
 */
class Bootstrap
{

    /** @var ServiceManager */
    protected $serviceManager;

    /**
     * Sets up the
     */
    public function init()
    {
        // autoloading setup
        static::initAutoloader();
        // main configuration
        $config = require_once __DIR__ . '/../config/application.config.php';
        // service manager setup
        $this->setUpServiceManager($config);
        // application setup
        $this->bootstrapApplication($config);
        // database setup
        $dbConfigs = $this->serviceManager->get('Config')['db'];
        self::setUpDatabase($dbConfigs);
    }

    public function chroot()
    {
        $rootPath = dirname(static::findParentPath('module'));
        chdir($rootPath);
    }

    protected function setUpServiceManager($config)
    {
        $serviceManagerConfig = isset($config['service_manager']) ? $config['service_manager'] : [];
        $serviceManagerConfigObject = new ServiceManagerConfig($serviceManagerConfig);
        $this->serviceManager = new ServiceManager();
        $serviceManagerConfigObject->configureServiceManager($this->serviceManager);
    }

    protected function bootstrapApplication($config)
    {
        $this->serviceManager->setService('ApplicationConfig', $config);
        $this->serviceManager->get('ModuleManager')->loadModules();
        $listenersFromAppConfig     = isset($configuration['listeners']) ? $configuration['listeners'] : [];
        $config                     = $this->serviceManager->get('config');
        $listenersFromConfigService = isset($config['listeners']) ? $config['listeners'] : [];
        $listeners = array_unique(array_merge($listenersFromConfigService, $listenersFromAppConfig));
        $application = $this->serviceManager->get('Application');
        $application->bootstrap($listeners);
    }

    protected function setUpDatabase(array $dbConfigs)
    {
        $databaseInitializer = new DatabaseInitializer($dbConfigs);
        $databaseInitializer->setUp();
        AbstractIntegrationTest::setDbConfigs($dbConfigs);
    }

    protected function initAutoloader()
    {
        $vendorPath = static::findParentPath('vendor');

        if (file_exists($vendorPath.'/autoload.php')) {
            include $vendorPath.'/autoload.php';
        }

        if (! class_exists('Zend\Loader\AutoloaderFactory')) {
            throw new RuntimeException(
                'Unable to load ZF2. Run `php composer.phar install`'
            );
        }

        AutoloaderFactory::factory(array(
            'Zend\Loader\StandardAutoloader' => array(
                'autoregister_zf' => true,
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__,
                ),
            ),
        ));
    }

    protected function findParentPath($path)
    {
        $dir = __DIR__;
        $previousDir = '.';
        while (!is_dir($dir . '/' . $path)) {
            $dir = dirname($dir);
            if ($previousDir === $dir) {
                return false;
            }
            $previousDir = $dir;
        }
        return $dir . '/' . $path;
    }

}

$bootstrap = new Bootstrap();
$bootstrap->init();
$bootstrap->chroot();
