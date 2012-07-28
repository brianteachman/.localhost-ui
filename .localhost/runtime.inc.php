<?php
// User configuration

define('HTTPD', dirname(__DIR__));
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
define('CURRENT_DIR', '.');
//
define('APP_LINK', DOMAIN_NAME . '/.localhost/');
define('ASSETS_LINK', APP_LINK . 'assets/');
define('SCRIPTS', APP_LINK . 'scripts/');

// PSR-0 Loader
require('vendor/autoload.php');

require(APP_PATH.'/src/functions.inc.php');
require(APP_PATH.'/src/view_helpers.inc.php');

session_start();
