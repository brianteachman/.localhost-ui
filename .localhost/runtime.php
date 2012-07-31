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
        $files = $host->readIt( $local_docs );
        $file_meta = array(
            'title' => 'Local Docs',
            'tagline' => 'Listing: localhost/docs',
            'slug' => '?list=' . $local_docs,
        );
        $host->build($files, $file_meta);

        $pear_docs = $host->readIt( PEAR_DOC_PATH );
        $pear_meta = array(
            'title' => 'PEAR Docs',
            'tagline' => 'Listing: ' . PEAR_DOC_PATH,
            'slug' => '?list=' . PEAR_DOC_PATH,
        );
        $host->build($pear_docs, $pear_meta);
        
        $view->render($host);
        
    } else {

        list($resource, $subdir) = $host->parse($_GET["list"]);
        
        if (is_array($resource)) {
        
            //@todo prepend $dir to all links in listed directory using javascript
            $dir = realpath(dirname($_GET["list"]));

            $file_meta = array(
                'title' => 'File Handler',
                'tagline' => $dir,
                'slug' => "?list={$dir}/",
            );
            if (isset($subdir)) {
                $file_meta["title"] = ucfirst($subdir);
                $file_meta["tagline"] .= "/$subdir/";
                $file_meta["slug"] .= "$subdir/";
            }
            $host->build($resource, $file_meta);
            
            $view->render($host);
            
        } else {
            echo $view->head('Resource Listing');
            echo $resource;
            echo $view->foot();
        }
        
        
    }
    
} else {

    $files = $host->readIt( CURRENT_DIR );
    $file_meta = array(
        'title' => 'localhost',
        'tagline' => 'Listing: ' . getcwd(),
        'slug' => '?list=' . HTTPD . '/',
    );
    $host->build($files, $file_meta);

    $virtual_host = $host->readIt( VHOST );
    $vhost_meta = array(
        'title' => 'VirtualHost',
        'tagline' => 'Site Development',
        'slug' => 'http://',
    );
    $host->build($virtual_host, $vhost_meta, 'vhost');
    
    $view->render($host);
}
?>
