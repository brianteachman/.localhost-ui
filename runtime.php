<?php

/**
 * Simple localhost interface.
 * 
 * @author Brian Teachman, Teachman Web Development <me@briant.me>
 * @license WTFPL <http://sam.zoy.org/wtfpl/COPYING>
 */
session_start();
 
// PSR-0 Loaders
$loader = require 'vendor/autoload.php';
// $loader->add('Localhost', 'classes/');

$config = include 'runtime.config.php';

$host = new \Localhost\ResourceLister(
    new \Localhost\View('Teachman Web'),
    $config
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
//         'slug' => '?list=' . $config['httpd'] . '/',
    );
    $host->set($config['current_dir'], $file_meta);

    $vhost_meta = array(
        'title' => 'VirtualHost',
        'tagline' => 'Site Development',
        'slug' => 'http://',
    );
    $host->set('/etc/apache2/sites-enabled', $vhost_meta, 'vhost');
    
    $host->view();
}
?>
