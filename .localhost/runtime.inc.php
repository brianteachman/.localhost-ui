<?php
// User configuration

define('HTTPD', realpath(dirname(__DIR__)));
define('SYS_DOC_ROOT', '/usr/share/doc');
define('VHOST', '/etc/apache2/sites-enabled');

define('LOCAL_DOCS', HTTPD . '/docs');
define('PEAR_DOC_PATH', SYS_DOC_ROOT . '/php-pear/PEAR/');
//
define('DOMAIN_NAME', ''); // Empty string for localhost


/* -------------------------------------------------------- */
/* EDIT BELOW IF NEEDED                                     */
/* -------------------------------------------------------- */
// Internals
define('APP_PATH', HTTPD . '/.localhost/');
define('VENDOR', APP_PATH . '/vendor/');
define('CURRENT_DIR', realpath('.'));
//
define('APP_LINK', DOMAIN_NAME . '/.localhost/');
define('ASSETS', APP_LINK . 'assets/');
define('SCRIPTS', ASSETS . 'scripts/');

// PSR-0 Loaders
require('vendor/autoload.php');
spl_autoload_register(function($class) {
    include(realpath(__DIR__).'/src/'.$class.'.php');
});

session_start();
