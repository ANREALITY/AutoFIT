<?php
use Zend\ServiceManager\ServiceManager;

namespace Test;

use DbSystel\Test\AbstractIntegrationTest;
use DbSystel\Test\DatabaseInitializer;
use Zend\Loader\AutoloaderFactory;
use Zend\Mvc\Application;
use Zend\Mvc\Service\ServiceManagerConfig;
use Zend\ServiceManager\ServiceManager;
use RuntimeException;

error_reporting(E_ALL | E_STRICT);
chdir(__DIR__);

/**
 * Test bootstrap, for setting up autoloading
 */
class Bootstrap
{
    /** @var ServiceManager */
    protected static $serviceManager;

    public static function init()
    {
        static::initAutoloader();

        // use ModuleManager to load this module and it's dependencies
        $config = require_once __DIR__ . '/../config/test.config.php';

        $serviceManager = new ServiceManager(new ServiceManagerConfig());
        $serviceManager->setService('ApplicationConfig', $config);
        $serviceManager->get('ModuleManager')->loadModules();

        $application = new Application($config, $serviceManager);
        $application->bootstrap();

        static::$serviceManager = $serviceManager;

        $configs = array_merge_recursive(
            require_once __DIR__ . '/../config/autoload/test/test.global.php',
            require_once __DIR__ . '/../config/autoload/test/test.local.php',
            // modules (manual loading for now) todo automate this!
            require_once __DIR__ . '/../config/autoload/module/audit-logging.local.php',
            require_once __DIR__ . '/../config/autoload/module/authorization.global.php',
            require_once __DIR__ . '/../config/autoload/module/error-handling.local.php',
            require_once __DIR__ . '/../config/autoload/module/zenddevelopertools.local.php'
        );
        $dbConfigs = $configs['test']['db'];
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

    public static function chroot()
    {
        $rootPath = dirname(static::findParentPath('module'));
        chdir($rootPath);
    }

    public static function getServiceManager()
    {
        return static::$serviceManager;
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