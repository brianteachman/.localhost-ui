<?php
// User configuration


define('VHOST', '/etc/apache2/sites-enabled');
define('SYS_DOC_ROOT', '/usr/share/doc');
define('PEAR_DOC_PATH', SYS_DOC_ROOT . '/php-pear/PEAR/');
//
define('DOMAIN_NAME', 'localhost-ui'); // use this as app level component
// define('DOMAIN_NAME', ''); // use this for localhost
define('SYS_DOC_LINK', DOMAIN_NAME . '/doc/');
define('PEAR_DOC_LINK', SYS_DOC_LINK . 'php-pear/PEAR/');


/* -------------------------------------------------------- */
/* EDIT BELOW IF NEEDED                                     */
/* -------------------------------------------------------- */
// Internals
define('HTTPD', dirname(__DIR__));
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
