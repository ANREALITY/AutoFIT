<?php
namespace Test;

use DbSystel\Test\AbstractControllerTest;
use DbSystel\Test\AbstractDbTest;
use DbSystel\Test\DatabaseInitializer;
use Doctrine\ORM\EntityManager;
use RuntimeException;
use Zend\Loader\AutoloaderFactory;
use Zend\Mvc\Service\ServiceManagerConfig;
use Zend\ServiceManager\ServiceManager;

error_reporting(E_ALL | E_STRICT);
ini_set('memory_limit', '768M');
chdir(__DIR__);

/**
 * Sets up the MVC (application, service manager, autoloading) and the database.
 */
class Bootstrap
{

    /** @var ServiceManager */
    protected $serviceManager;

    protected $applicationConfigPath;

    /** @var EntityManager */
    protected $entityManager;

    public function __construct()
    {
        $this->applicationConfigPath = __DIR__ . '/../config/application.config.php';
    }

    /**
     * Sets up the
     */
    public function init()
    {
        // autoloading setup
        static::initAutoloader();
        // application configuration
        $applicationConfig = require_once $this->applicationConfigPath;
        // service manager setup
        $this->setUpServiceManager($applicationConfig);
        // database setup
        $dbConfigs = $this->serviceManager->get('Config')['db'];
        self::setUpDatabase($dbConfigs);
        // application setup
        $this->bootstrapApplication($applicationConfig);
        // Doctrine entity manager
        $this->entityManager = $this->serviceManager->get('doctrine.entitymanager.orm_default');
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
        // modules and configs for the application's ServiceManager
        $this->serviceManager->setService('ApplicationConfig', $config);
        $this->serviceManager->get('ModuleManager')->loadModules();
    }

    protected function bootstrapApplication($config)
    {
        $listeners = $this->prepareListeners();
        $application = $this->serviceManager->get('Application');
        $application->bootstrap($listeners);
    }

    protected function prepareListeners()
    {
        $listenersFromAppConfig     = isset($configuration['listeners']) ? $configuration['listeners'] : [];
        $config                     = $this->serviceManager->get('config');
        $listenersFromConfigService = isset($config['listeners']) ? $config['listeners'] : [];
        $listeners = array_unique(array_merge($listenersFromConfigService, $listenersFromAppConfig));
        return $listeners;
    }

    protected function setUpDatabase(array $dbConfigs)
    {
        $databaseInitializer = new DatabaseInitializer($dbConfigs);
        $databaseInitializer->setUp();
        AbstractDbTest::setDbConfigs($dbConfigs);
        AbstractControllerTest::setApplicationConfigPath($this->applicationConfigPath);
        AbstractControllerTest::setDbConfigs($dbConfigs);
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
