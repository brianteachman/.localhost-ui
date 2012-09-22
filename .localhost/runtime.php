<?php

/**
 * Simple localhost interface.
 * 
 * @author Brian Teachman, Teachman Web Development <me@briant.me>
 * @license WTFPL <http://sam.zoy.org/wtfpl/COPYING>
 */
session_start();
 
$config = include 'runtime.config.php';

// PSR-0 Loaders
require 'vendor/autoload.php';
include 'vendor/SplClassLoader.php';

$loader = new SplClassLoader('Localhost', realpath(__DIR__) . '/classes');
$loader->register();

// spl_autoload_register(function($class) {
//     include realpath(__DIR__).'/src/'.$class.'.php';
// });

$host = new \Localhost\ResourceLister(
    new \Localhost\View('Teachman Web', $config)
);

if (isset($_GET["list"])) {

    if ($_GET["list"] == 'all') {
        
        $local_docs = $config['httpd'] . '/docs/';
        $file_meta = array(
            'title' => 'Local Docs',
            'tagline' => 'Listing: localhost/docs',
            'slug' => '?list=' . $local_docs,
        );
        $host->set($local_docs, $file_meta);

        $pear_meta = array(
            'title' => 'PEAR Docs',
            'tagline' => 'Listing: ' . $config['pear_docs'],
            'slug' => '?list=' . $config['pear_docs'],
        );
        $host->set($config['pear_docs'], $pear_meta);
        
        $host->view();
        
    } else {

        $style = $host->set($_GET["list"]);
        $host->view($style);
        
    }
    
} else {

    $file_meta = array(
        'title' => 'localhost',
        'tagline' => 'Listing: ' . getcwd(),
        'slug' => '?list=' . $config['httpd'] . '/',
    );
    $host->set($config['current_dir'], $file_meta);

    $vhost_meta = array(
        'title' => 'VirtualHost',
        'tagline' => 'Site Development',
        'slug' => 'http://',
    );
    $host->set('/etc/apache2/sites-enabled', $vhost_meta, 'vhost');
    
    $vhost_meta = array(
        'title' => 'Resources',
        'tagline' => 'Templates and stuff',
//         'slug' => 'Templates/',
    );
    $host->set('Templates', $vhost_meta, 'vhost');
    
    $host->view();
}
?>
