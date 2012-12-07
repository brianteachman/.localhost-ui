<?php
// User configuration
$domain = ''; // Empty string for localhost

$root = realpath(dirname(__DIR__));

$config = array(
    'httpd' => $root,
    'current_dir' => realpath('.'),
    'app_path' => "{$root}/.localhost-ui/",
    'vendor' => "{$root}/.localhost-ui/vendor/",
    'local_docs' => "{$root}/docs",
    'sys_docs' => '/usr/share/doc',
    'pear_docs' => '/usr/share/doc/php-pear/PEAR/',
    //
    'domain' => $domain,
    'app_link' => "{$domain}/.localhost-ui/",
    'assets' => "{$domain}/.localhost-ui/assets/",
    'scripts' => "{$domain}/.localhost-ui/assets/scripts/",
);

if (IS_WIN) {
    $config['pear_docs'] = "C:\Program Files (x86)\Zend\ZendServer\bin\PEAR";
}
return $config;