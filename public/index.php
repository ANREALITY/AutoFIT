<?php
/**
 * This makes our life easier when dealing with paths. Everything is relative
 * to the application root now.
 */
chdir(dirname(__DIR__));

// Decline static file requests back to the PHP built-in webserver
if (php_sapi_name() === 'cli-server' && is_file(__DIR__ . parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH))) {
    return false;
}

// Setup autoloading
require 'init_autoloader.php';

session_start();
if (!empty($_SERVER['AUTH_USER'])) {
    $_SESSION['username'] = strrchr($_SERVER['AUTH_USER'], "\\")
        ? str_ireplace("\\", '', strrchr($_SERVER['AUTH_USER'], "\\"))
        : $_SERVER['AUTH_USER']
    ;
} else {
    $_SESSION['username'] = 'Foo Bar';
}

// Run the application!
Zend\Mvc\Application::init(require 'config/application.config.php')->run();
