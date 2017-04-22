<?php
namespace Test;

use Zend\Mvc\Application;
use Zend\Loader\AutoloaderFactory;
use Zend\Mvc\Service\ServiceManagerConfig;
use Zend\ServiceManager\ServiceManager;
use Zend\Stdlib\ArrayUtils;
error_reporting(E_ALL | E_STRICT);

/**
 * Test bootstrap, for setting up autoloading
 */
class Bootstrap
{

    /**
     *
     * @var ServiceManager
     */
    protected static $serviceManager;

    /**
     *
     * @var Application
     */
    protected static $application;

    /**
     *
     * @var Application
     */
    private $app;

    public static function init()
    {
        $zf2ModulePaths = array(
            dirname(dirname(__DIR__))
        );
        if (($path = static::findParentPath('vendor'))) {
            $zf2ModulePaths[] = $path;
        }
        if (($path = static::findParentPath('module')) !== $zf2ModulePaths[0]) {
            $zf2ModulePaths[] = $path;
        }

        static::initAutoloader();

        // use ModuleManager to load this module and it's dependencies
        $config = array(
            'module_listener_options' => array(
                'module_paths' => $zf2ModulePaths
            ),
            'modules' => array(
                'Order'
            )
        );

        $serviceManager = new ServiceManager(new ServiceManagerConfig());
        $serviceManager->setService('ApplicationConfig', $config);
        $serviceManager->get('ModuleManager')->loadModules();
        $serviceManager->setAllowOverride(true);
        static::$serviceManager = $serviceManager;
    }

    public static function chroot()
    {
        $rootPath = dirname(static::findParentPath('module'));
        chdir($rootPath);
    }

    public static function setServiceManager($serviceManager)
    {
        static::$serviceManager = $serviceManager;
    }

    public static function getServiceManager()
    {
        return static::$serviceManager;
    }

    public static function setApplication($application)
    {
        static::$application = $application;
    }

    public static function getApplication()
    {
        return static::$application;
    }

    protected static function initAutoloader()
    {
        $vendorPath = static::findParentPath('vendor');

        $zf2Path = getenv('ZF2_PATH');
        if (! $zf2Path) {
            if (defined('ZF2_PATH')) {
                $zf2Path = ZF2_PATH;
            } elseif (is_dir($vendorPath . '/ZF2/library')) {
                $zf2Path = $vendorPath . '/ZF2/library';
            } elseif (is_dir($vendorPath . '/zendframework/zendframework/library')) {
                $zf2Path = $vendorPath . '/zendframework/zendframework/library';
            }
        }

        if (! $zf2Path) {
            throw new \RuntimeException('Unable to load ZF2. Run `php composer.phar install` or' . ' define a ZF2_PATH environment variable.');
        }

        if (file_exists($vendorPath . '/autoload.php')) {
            include $vendorPath . '/autoload.php';
        }

        include $zf2Path . '/Zend/Loader/AutoloaderFactory.php';
        AutoloaderFactory::factory(array(
            'Zend\Loader\StandardAutoloader' => array(
                'autoregister_zf' => true,
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . 'Bootstrap.php/' . __NAMESPACE__
                )
            )
        ));
    }

    protected static function findParentPath($path)
    {
        $dir = __DIR__;
        $previousDir = '.';
        while (! is_dir($dir . '/' . $path)) {
            $dir = dirname($dir);
            if ($previousDir === $dir) {
                return false;
            }
            $previousDir = $dir;
        }
        return $dir . '/' . $path;
    }

    public function __destruct()
    {
        self::tearDown($this->app);
    }

    public function __construct($application)
    {
        $this->app = $application;
        self::setUp($application);
    }

    protected static function setUp($application)
    {
        // echo "\n====START SET UP====\n";
        $config = $application->getConfig();

        /*
         * if (isset($config['integrationTest'])) {
         * $testConfig = $config['integrationTest'];
         * if (isset($testConfig['migrateScript'])) {
         * $dbConfig = $config['doctrine']['connection']['orm_default']['params'];
         * $options = '-c ' . $testConfig['createDatabaseFile'] . ' -s ' . $testConfig['updateDirectory'] . ' -d '
         * . $dbConfig['dbname'] . ' -u ' . $dbConfig['user'] . ' -p ' . $dbConfig['password'];
         * echo " -> running migrateScript:" . $testConfig['migrateScript'] . "\n";
         * echo exec($testConfig['migrateScript'] . ' ' . $options);
         * }
         * } else {
         * echo "WARNING: no integrationTest Configuration found\n";
         * }
         */

        // echo "\n=====END SET UP=====\n";
    }

    protected static function tearDown($application)
    {
        // echo "\n===START TEAR DOWN===\n";

        /*
         * $config = $application->getConfig();
         * $dbConfig = $config['doctrine']['connection']['orm_default']['params'];
         * $em = $application->getServiceManager()->get('Doctrine\ORM\EntityManager');
         * $em->getConnection()->exec('DROP DATABASE `'.$dbConfig['dbname'].'`');
         */

        // echo "\n====END TEAR DOWN====\n";
    }
}

// Setup autoloading
require 'init_autoloader.php';

if (! defined('APPLICATION_PATH')) {
    define('APPLICATION_PATH', realpath(__DIR__ . '/../'));
}

$appConfig = include APPLICATION_PATH . '/config/application.config.php';

if (file_exists(APPLICATION_PATH . '/config/application.config.integrationtest.php')) {
    $appConfig = ArrayUtils::merge($appConfig, include APPLICATION_PATH . '/config/application.config.integrationtest.php');
}

// Some OS/Web Server combinations do not glob properly for paths unless they
// are fully qualified (e.g., IBM i). The following prefixes the default glob
// path with the value of the current working directory to ensure configuration
// globbing will work cross-platform.
// if (isset($appConfig['module_listener_options']['config_glob_paths'])) {
//     foreach ($appConfig['module_listener_options']['config_glob_paths'] as $index => $path) {
//         $appConfig['module_listener_options']['config_glob_paths'][$index] = APPLICATION_PATH . $path;
//     }
// }

// Run the application!
$application = Application::init($appConfig);

$bootstrap = new Bootstrap($application);

Bootstrap::setApplication($application);
Bootstrap::setServiceManager($application->getServiceManager());

// Bootstrap::init();
Bootstrap::chroot();
