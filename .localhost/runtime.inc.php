<?php
// User configuration
define('VHOST', '/etc/apache2/sites-enabled');
define('SYS_DOC_ROOT', '/usr/share/doc');
define('PEAR_DOC_PATH', SYS_DOC_ROOT . '/php-pear/PEAR/');
//
define('SYS_DOC_LINK', '/doc/');
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
define('APP_LINK', '/.localhost/');
define('ASSETS_LINK', APP_LINK . 'assets/');
define('SCRIPTS', APP_LINK . 'scripts/');

// Smoke em if you got em!
// require(VENDOR.'php_error.php');
// \php_error\reportErrors();

require(APP_PATH.'/src/functions.inc.php');
require(APP_PATH.'/src/view_helpers.inc.php');

session_start();
