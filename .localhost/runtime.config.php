<?php
// User configuration
$domain = ''; // Empty string for localhost

$root = realpath(dirname(__DIR__));

return array(
    'httpd' => $root,
    'current_dir' => realpath('.'),
    'app_path' => "{$root}/.localhost/",
    'vendor' => "{$root}/.localhost/vendor/",
    'local_docs' => "{$root}/docs",
    'sys_docs' => '/usr/share/doc',
    'pear_docs' => '/usr/share/doc/php-pear/PEAR/',
    //
    'domain' => $domain,
    'app_link' => "{$domain}/.localhost/",
    'assets' => "{$domain}/.localhost/assets/",
    'scripts' => "{$domain}/.localhost/assets/scripts/",
);
