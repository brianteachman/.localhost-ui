<?php
/**
 * Simple localhost interface.
 * 
 * @author Brian Teachman, Teachman Web Development <me@briant.me>
 * @license WTFPL <http://sam.zoy.org/wtfpl/COPYING>
 */
include('runtime.inc.php');

$host = new Localhost();
$view = new View();

if (isset($_GET["list"])) {

    if ($_GET["list"] == 'all') {
        
        $local_docs = HTTPD . '/docs/';
        $file_meta = array(
            'title' => 'Local Docs',
            'tagline' => 'Listing: localhost/docs',
            'slug' => '?list=' . $local_docs,
        );
        $host->set($local_docs, $file_meta);

        $pear_meta = array(
            'title' => 'PEAR Docs',
            'tagline' => 'Listing: ' . PEAR_DOC_PATH,
            'slug' => '?list=' . PEAR_DOC_PATH,
        );
        $host->set(PEAR_DOC_PATH, $pear_meta);
        
        $view->render($host);
        
    } else {

        $style = $host->set($_GET["list"]);
        $view->render($host, $style);
        
    }
    
} else {

    $file_meta = array(
        'title' => 'localhost',
        'tagline' => 'Listing: ' . getcwd(),
    );
    $host->set(CURRENT_DIR, $file_meta);

    $vhost_meta = array(
        'title' => 'VirtualHost',
        'tagline' => 'Site Development',
    );
    $host->set(VHOST, $vhost_meta, 'vhost');
    
    $view->render($host);
}
?>
