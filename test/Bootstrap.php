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
    protected static $serviceManager;

    /**
     * Sets up the
     */
    public static function init()
    {
        // autoloading setup
        static::initAutoloader();

        // main configuration
        $config = require_once __DIR__ . '/../config/application.config.php';

        // service manager setup
        // self::setUpServiceManager($config);
        $serviceManagerConfig = isset($config['service_manager']) ? $config['service_manager'] : [];
        $serviceManagerConfigObject = new ServiceManagerConfig($serviceManagerConfig);
        // $serviceManagerConfigArray = $serviceManagerConfigObject->toArray();

        static::$serviceManager = new ServiceManager();
        $serviceManagerConfigObject->configureServiceManager(self::$serviceManager);

        // application setup
        // self::bootstrapApplication($config);
        static::$serviceManager->setService('ApplicationConfig', $config);

        static::$serviceManager->get('ModuleManager')->loadModules();

        $listenersFromAppConfig     = isset($configuration['listeners']) ? $configuration['listeners'] : [];
        $config                     = static::$serviceManager->get('config');
        $listenersFromConfigService = isset($config['listeners']) ? $config['listeners'] : [];

        $listeners = array_unique(array_merge($listenersFromConfigService, $listenersFromAppConfig));

        $application = static::$serviceManager->get('Application');

        $application->bootstrap($listeners);

        // database setup
        $dbConfigs = static::$serviceManager->get('Config')['db'];
        self::setUpDatabase($dbConfigs);
    }

    public static function chroot()
    {
        $rootPath = dirname(static::findParentPath('module'));
        chdir($rootPath);
    }

    public static function setUpDatabase(array $dbConfigs)
    {
        $databaseInitializer = new DatabaseInitializer($dbConfigs);

        $schemaSql = file_get_contents($dbConfigs['scripts']['schema']);
        $storedProceduresSql = file_get_contents($dbConfigs['scripts']['stored-procedures']);
        $basicDataSql = file_get_contents($dbConfigs['scripts']['basic-data']);
        $testDataSql = array_map(function ($sqlFile) {
            return file_get_contents($sqlFile);
        }, $dbConfigs['scripts']['test-data']);
        $databaseInitializer->setUp($schemaSql, $storedProceduresSql, $basicDataSql, $testDataSql);

        AbstractIntegrationTest::setDbConfigs($dbConfigs);
    }

    protected static function initAutoloader()
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

    protected static function findParentPath($path)
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

Bootstrap::init();
Bootstrap::chroot();