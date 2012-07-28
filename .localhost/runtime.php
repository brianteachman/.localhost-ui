<?php
/**
 * Simple localhost interface.
 * 
 * @author Brian Teachman, Teachman Web Development <me@briant.me>
 * @license WTFPL <http://sam.zoy.org/wtfpl/COPYING>
 */
include('runtime.inc.php');

echo head('Simple localhost interface');

flash_messenger();

if (isset($_GET["list"])) {

    if ($_GET["list"] == 'all') {
        
        $local_docs = HTTPD . '/docs/';
        $files = listIt( $local_docs );
        $file_meta = array(
            'title' => 'Local Docs',
            'tagline' => 'Listing: localhost/docs',
            'slug' => '?list=' . $local_docs,
        );
        echo list_module($files, $file_meta);

        $pear_docs = listIt( PEAR_DOC_PATH );
        $pear_meta = array(
            'title' => 'PEAR Docs',
            'tagline' => 'Listing: ' . PEAR_DOC_PATH,
            'slug' => '?list=' . PEAR_DOC_PATH,
        );
        echo list_module($pear_docs, $pear_meta);
        
    } else {

        list($resource, $subdir) = parse($_GET["list"]);
        
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
            echo list_module($resource, $file_meta);
        } else {

            echo $resource ;
        }
    }
    
} else {

    $files = listIt( CURRENT_DIR );
    $file_meta = array(
        'title' => 'localhost',
        'tagline' => 'Listing: ' . getcwd(),
    //     'slug' => '',
    );
    echo list_module($files, $file_meta);

    $virtual_host = listIt( VHOST );
    $vhost_meta = array(
        'title' => 'VirtualHost',
        'tagline' => 'Site Development',
        'slug' => 'http://',
    );
    echo list_module($virtual_host, $vhost_meta, 'vhost');
}

echo foot();
?>
